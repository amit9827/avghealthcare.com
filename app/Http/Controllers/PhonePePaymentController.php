<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Order;

//https://developer.phonepe.com/payment-gateway/website-integration/standard-checkout/api-integration/api-reference/order-status#nav-environment



class PhonePePaymentController extends Controller
{

    public $env, $PHONEPE_OATH_TOKEN_URL, $PHONEPE_CHECKOUT_URL, $PHONEPE_CLIENT_SECRET, $PHONEPE_CLIENT_ID;

    public function __construct()
    {
        $this->env=env('PHONEPE_ENV');

        if($this->env=="prod"){

            $this->PHONEPE_OATH_TOKEN_URL=env('PHONEPE_OATH_TOKEN_URL');
            $this->PHONEPE_CHECKOUT_URL=env('PHONEPE_CHECKOUT_URL');
            $this->PHONEPE_CLIENT_SECRET=env('PHONEPE_CLIENT_SECRET');
            $this->PHONEPE_CLIENT_ID=env('PHONEPE_CLIENT_ID');

        }else{

            $this->PHONEPE_OATH_TOKEN_URL=env('PHONEPE_UAT_OATH_TOKEN_URL');
            $this->PHONEPE_CHECKOUT_URL=env('PHONEPE_UAT_CHECKOUT_URL');
            $this->PHONEPE_CLIENT_SECRET=env('PHONEPE_UAT_CLIENT_SECRET');
            $this->PHONEPE_CLIENT_ID=env('PHONEPE_UAT_CLIENT_ID');
        }
    }



    public function createPayment(Request $request, $order_id)
    {


        $response = Http::asForm()->post( $this->PHONEPE_OATH_TOKEN_URL, [
            'client_id' =>  $this->PHONEPE_CLIENT_ID,
            'client_version' => '1',
            'client_secret' =>  $this->PHONEPE_CLIENT_SECRET,
            'grant_type' => 'client_credentials',
        ]);


        $data = $response->json();


        if ($response->successful()) {
             $accessToken = $data['access_token'] ?? null;

             $order = Order::find($order_id);


            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => 'O-Bearer ' . $accessToken,
            ])->post($this->PHONEPE_CHECKOUT_URL, [
                'merchantOrderId' => $order->id,
                'amount' => $order->total_amount,
                'paymentFlow' => [
                    'type' => 'PG_CHECKOUT',
                    'message' => 'Payment message used for collect requests',
                    'merchantUrls' => [
                        'redirectUrl' => route('phonepe.success', ['id' => $order->id]),
                    ],
                ],
            ]);


            return $data = $response->json();
            return redirect($data['redirectUrl']);

        } else {

            \Log::error('PhonePe token request failed', ['response' => $data]);

            return $data;
        }
    }


    public function success($id)
    {
        $order = Order::find($id);
        $order->order_status="COMPLETED";

        dd('Payment successful for order ID: ' . $id);
    }
}

