<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use DateTime;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payments.pay');
    }

    // Create auth
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

    // Create session and load the web checkout
    private function createSession($order)
    {
        $auth = $this->createAuth();
        $expiration = strtotime(date('Y-m-d H:i:s')) + 600;

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
            'returnUrl' => env('APP_URL') . '/orders/pay/confirm',
            'cancelUrl' => env('APP_URL') . '/orders/pay/cancel',
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],

        ];

        $response = Http::post(env('PAYMENT_BASE_URL').'/api/session', $body)->json();

        return $response;
    }

    private function checkSession()
    {
        $current_requestId = $_COOKIE['current_payment'];
        $auth = $this->createAuth();

        $body = [
            'auth' => [
                'login' => env('PAYMENT_LOGIN'),
                'tranKey' => base64_encode($auth['tranKey']),
                'nonce' => base64_encode($auth['nonce']),
                'seed' => $auth['seed']
            ]
        ];

        $response = Http::post(env('PAYMENT_BASE_URL').'/api/session/'.$current_requestId, $body)->json();

        return $response;
    }

    public function pay(Request $request)
    {
        $response = $this->createSession($request->all());
        $view = view('payments.pay', ['response' => $response['status']]);

        if ( $response['status']['status'] === 'OK' ) {
            // add requestId to order
            $add_requestId = $this->addRequestId($response['requestId'], $request->order_id);

            // Validate if requestId field was updated
            if ( $add_requestId == $response['requestId'] ) {
                setcookie('current_payment', $add_requestId, strtotime(date('c')) + 600, '/');
                return redirect($response['processUrl']);
            }

            return $view;
        }

        return $view;
    }

    public function status(Request $request)
    {
        $response = [
            'status' => [
                'status' => 'NO_COOKIE'
            ]
        ];

        $order = [];

        // Get payment session status
        if ( !empty($_COOKIE['current_payment']) ) {
            $response = $this->checkSession();

            $payment_fields = [
                'order_id' => $response['request']['payment']['reference'],
                'payment_status' => $response['status']['status']
            ];

            $order = $this->updatePaymentsField($payment_fields);
        }

        //print_r($order);

        return view('payments.status', [
            'response' => $response,
            'order' => $order
        ]);
    }

    // Update payments field
    private function updatePaymentsField($response)
    {
        $legacy_statuses = [
            'APPROVED' => 'PAYED',
            'REJECTED' => 'REJECTED'
        ];

        $legacy_status = $legacy_statuses[$response['payment_status']];

        $order = Order::find($response['order_id']);
        $order->payment_status = $response['payment_status'];
        $order->status = $legacy_status ? $legacy_status : 'CREATED';
        $order->save();

        return $order;
    }

    // Add the requestId
    private function addRequestId($requestId, $id)
    {
        $order = Order::find($id);
        $order->payment_requestId = $requestId;
        $order->save();

        return $order['payment_requestId'];
    }
}
