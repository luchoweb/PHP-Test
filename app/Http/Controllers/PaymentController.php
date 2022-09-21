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

    // Create session and load the web checkout
    private function createSession($order)
    {
        $nonce = rand().$order['order_id'];
        $now = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $seed = $now->format(DateTime::ATOM);
        $tranKey = sha1($nonce . $seed . env('PAYMENT_SECRET_KEY'), true);
        $expiration = strtotime(date('Y-m-d H:i:s')) + 3600;

        $body = [
            'locale' => 'es_CO',
            'auth' => [
                'login' => env('PAYMENT_LOGIN'),
                'tranKey' => base64_encode($tranKey),
                'nonce' => base64_encode($nonce),
                'seed' => $seed
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

    public function pay(Request $request)
    {
        $response = $this->createSession($request->all());

        if ( $response['status']['status'] === 'OK' ) {
            return redirect($response['processUrl']);
        }

        return view('payments.pay', ['response' => $response['status']]);
    }

    public function confirm(Request $request)
    {
        // Update order using update private funcion: TODO

        print_r($request->all());

        //return view('payments.confirm');
    }

    public function cancel(Request $request)
    {
        // Update order using update private funcion: TODO

        print_r($request->all());

        //return view('payments.cancel');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function update(Request $request, $id)
    {
        //
    }
}
