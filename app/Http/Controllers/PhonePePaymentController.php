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

            echo  $accessToken .
            $this->PHONEPE_CHECKOUT_URL .
            $order->total_amount*100 .
            $order->id;
            $amount = $order->total_amount*100;
            $merchantOrderId = "TX".$order->id;
            $key = time();
            $request->session()->put('key', $key);
            $redirectUrl = route('phonepe.success', [
                'id' => $order->id,
                'key' => $key,
            ]);


            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => 'O-Bearer ' . $accessToken,
            ])->post($this->PHONEPE_CHECKOUT_URL, [
                'merchantOrderId' => $merchantOrderId,
                'amount' => $amount,
                'paymentFlow' => [
                    'type' => 'PG_CHECKOUT',
                    'message' => 'Payment message used for collect requests',
                    'merchantUrls' => [
                        'redirectUrl' => "$redirectUrl",
                    ],
                ],
            ]);

           /* {
                "merchantOrderId": "TX123456",
                "amount": 1000,
                "expireAfter": 1200,
                "metaInfo": {
                    "udf1": "additional-information-1",
                    "udf2": "additional-information-2",
                    "udf3": "additional-information-3",
                    "udf4": "additional-information-4",
                    "udf5": "additional-information-5"
                },
                "paymentFlow": {
                    "type": "PG_CHECKOUT",
                    "message": "Payment message used for collect requests",
                    "merchantUrls": {
                        "redirectUrl": ""
                    }
                }
            }*/

            $data = $response->json();

            if(isset($data['redirectUrl']))
            return redirect($data['redirectUrl']);
            return $data;

        } else {

            \Log::error('PhonePe token request failed', ['response' => $data]);

            return $data;
        }
    }


    public function success(Request $request, $id, $key)
    {
        $order = Order::find($id);
        $session_key = $request->session()->get('key');
        if($key != $session_key)
        return "Error $key mismatch $session_key";



        if($order)
        $order->order_status="COMPLETED";
        $order->save();

        dd('Payment successful for order ID: ' . $id);
    }



}

