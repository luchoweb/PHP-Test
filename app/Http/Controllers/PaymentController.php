<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use DateTime;

class PaymentController extends Controller
{
    // Create auth for new sessions
    private function createAuth()
    {
        $nonce = rand();
        $seed = date('c');

        return [
            'nonce' => $nonce,
            'seed' => $seed,
            'tranKey' => sha1($nonce . $seed . env('PAYMENT_SECRET_KEY'), true)
        ];
    }

    // Create a new session
    private function createSession($order)
    {
        // Get the auth info
        $auth = $this->createAuth();

        // Session expiration date
        $expiration = strtotime(date('Y-m-d H:i:s')) + 600;

        // Session body
        $body = [
            'locale' => 'es_CO',
            'auth' => [
                'login' => env('PAYMENT_LOGIN'),
                'tranKey' => base64_encode($auth['tranKey']),
                'nonce' => base64_encode($auth['nonce']),
                'seed' => $auth['seed']
            ],
            'payer' => [
                'document' => $order['customer_document'],
                'documentType' => $order['customer_documentType'],
                'name' => $order['customer_name'],
                'surname' => $order['customer_surname'],
                'email' => $order['customer_email'],
                'mobile' => '+57'.$order['customer_mobile']
            ],
            'payment' => [
                'reference' => $order['order_id'],
                'description' => 'Pay order #'.$order['order_id'],
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order['order_total']
                ],
            ],
            'expiration' => date('Y-m-d H:i:s', $expiration),
            'returnUrl' => env('APP_URL') . '/orders/pay/status',
            'cancelUrl' => env('APP_URL') . '/orders/pay/status',
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT']
        ];

        // Send request for new session
        $response = Http::post(env('PAYMENT_BASE_URL').'/api/session', $body)->json();

        // Return response
        return $response;
    }

    // Get session info by requestId
    private function checkSession($request_id)
    {
        // Get the auth info
        $auth = $this->createAuth();

        // Request body
        $body = [
            'auth' => [
                'login' => env('PAYMENT_LOGIN'),
                'tranKey' => base64_encode($auth['tranKey']),
                'nonce' => base64_encode($auth['nonce']),
                'seed' => $auth['seed']
            ]
        ];

        // Request response
        $response = Http::post(env('PAYMENT_BASE_URL').'/api/session/'.$request_id, $body)->json();

        // Return response
        return $response;
    }

    // Update payments field
    private function updatePaymentsField($fields)
    {
        $legacy_statuses = [
            'APPROVED' => 'PAYED',
            'REJECTED' => 'REJECTED'
        ];

        $legacy_status = in_array($fields['payment_status'], $legacy_statuses) ? $legacy_statuses[$fields['payment_status']] : 'CREATED';

        // Update order payments fields
        $order = Order::find($fields['order_id']);
        $order->payment_status = $fields['payment_status'];
        $order->status = $legacy_status;
        $order->save();

        // Return the order updated
        return $order;
    }

    // Add the requestId to the order
    private function addRequestId($request_id, $id)
    {
        // Find the right order
        $order = Order::find($id);
        // Update the field
        $order->payment_requestId = $request_id;
        // Save changes in the database
        $order->save();

        // Return payment_requestId
        return $order['payment_requestId'];
    }

    /** 
     * Route[POST]: /orders/pay
     * Save requestId in the order (database) and redirect to webcheckout
     * Or show a alert error in the view when the session wasn't created
     */
    public function pay(Request $request)
    {
        // Create a new session
        $response = $this->createSession($request->all());

        // Set up a view by default (Error response)
        $view = view('payments.pay', ['response' => $response['status']]);

        // Check if the new session was created
        if ( $response['status']['status'] === 'OK' ) {
            // Add requestId to order in database
            $add_request_id = $this->addRequestId($response['requestId'], $request->order_id);

            // Validate if requestId field was updated
            if ( $add_request_id == $response['requestId'] ) {
                // Set a cookie to use to verify the session status in the confirm page
                setcookie('current_payment', $add_request_id, strtotime(date('c')) + 600, '/');

                // Redirect to secure webcheckout
                return redirect($response['processUrl']);
            }
        }

        // Show the view by default
        return $view;
    }

    /**
     * Routes[GET]: /orders/pay/confirm, /orders/pay/cancel
     * Check a session with requestId === [COOKIE]->current_payment
     * If session has not expired, we show all details
     */
    public function status()
    {
        // Initial response, show an error message in the view
        $response = [
            'status' => [
                'status' => 'NO_COOKIE'
            ]
        ];

        // No orders by default
        $order = [];

        // Get payment session status
        if ( !empty($_COOKIE['current_payment']) ) {
            // Check session
            $response = $this->checkSession($_COOKIE['current_payment']);

            // Get order id from response
            $order_id = $response['request']['payment']['reference'];

            // Check if response is PENDING
            $is_session_pending = $response['status']['status'] === 'PENDING';

            // Get status
            $payment_status = 
                $is_session_pending ? 
                $response['status']['status'] : 
                $response['payment'][0]['status']['status'];

            // Get payment values
            $payment_fields = [
                'order_id' => $order_id,
                'payment_status' => $payment_status
            ];

            // Update the order status
            $order = $this->updatePaymentsField($payment_fields);
        }

        // What kind of console.log is this :P
        //print_r(json_encode($response));

        // Show the view
        return view('payments.status', [
            'response' => $response,
            'order' => $order
        ]);
    }

    /**
     * Route[API][POST]: /
     * Recived a notification from webchecout when an order change from PENDING to another status
     */
    public function pendingPayments(Request $request)
    {
        // Checking a valid request
        if ( $request !== NULL ) {
            $order_id = $request['reference'];

            // Cheking session status
            $session = $this->checkSession($order_id);

            $session_status = $session['status']['status'];
            $session_date = $session['status']['date'];
            $payment_status = $session_status === 'PENDING'  ? $session_status : $session['payment'][0]['status']['status'];

            $signature = sha1($request['requestID'] . $session_status . $session_date . env('PAYMENT_SECRET_KEY'), true);

            // Get order info
            $order = Order::find($order_id);

            $is_session_pending = $session_status === 'PENDING';
            $is_order_pending = $order['payment_status'] === 'PENDING';
            $is_signature_valid = $signature === $request['signature'];

            // Validate if session and order and pending, and if the signature is valid
            if ( $is_session_pending && $is_order_pending &&  $is_signature_valid ) {
                $payment_fields = [
                    'order_id' => $order_id,
                    'payment_status' => $payment_status
                ];
        
                $order = $this->updatePaymentsField($payment_fields);

                // We could send a notification by mail here ;)
            }
        }
    }
}
