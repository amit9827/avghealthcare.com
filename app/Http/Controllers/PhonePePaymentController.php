<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

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
            $this->PHONEPE_CHECKOUT_BASEURL = env('PHONEPE_CHECKOUT_BASEURL');


        }else{

            $this->PHONEPE_OATH_TOKEN_URL=env('PHONEPE_UAT_OATH_TOKEN_URL');
            $this->PHONEPE_CHECKOUT_URL=env('PHONEPE_UAT_CHECKOUT_URL');
            $this->PHONEPE_CLIENT_SECRET=env('PHONEPE_UAT_CLIENT_SECRET');
            $this->PHONEPE_CLIENT_ID=env('PHONEPE_UAT_CLIENT_ID');
            $this->PHONEPE_CHECKOUT_BASEURL = env('PHONEPE_UAT_CHECKOUT_BASEURL');

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


            $merchantOrderId = "TX".$order->id;

            // Save transaction ID in order record
            $order->payment_mode="PhonePe";
            $order->txn_id = $merchantOrderId;
            $order->order_status="PENDING";
            $order->save();


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
        // Verify payment via PhonePe
        $response = $this->verifyPayment($request, $id);

        // If verifyPayment() already updates the order status, no need to do it again
        if ($response->getStatusCode() !== 200) {
            return $response; // Return error JSON
        }

        $data = $response->getData(true); // Convert JsonResponse to array
        $order = Order::find($id);

        // Validate session key
        $session_key = $request->session()->get('key');
        if ($key != $session_key) {
            return response()->json([
                'error' => "Key mismatch: given=$key, expected=$session_key"
            ], 400);
        }

        // Extract status correctly
        $status = $data['state'] ?? $data['paymentDetails'][0]['state'] ?? null;

        // If payment is COMPLETED, you can add extra actions here
        if ($status === 'COMPLETED' && $order) {
            // Already updated inside verifyPayment(), but you can add extras:
            // Example: send email
            // Mail::to($order->customer_email)->send(new OrderConfirmed($order));

            echo "Order Complted";

               // Save in session
            }

            $request->session()->put('order_id', $data['orderId'] ?? $id);
            $request->session()->put('order_status', $status);

            return redirect()->route('order_status');


        //return response()->json($data); // Return the verification response
    }


    public function verifyPayment(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);

        // Step 1: Get access token
        $tokenResponse = Http::asForm()->post($this->PHONEPE_OATH_TOKEN_URL, [
            'client_id'      => $this->PHONEPE_CLIENT_ID,
            'client_version' => '1',
            'client_secret'  => $this->PHONEPE_CLIENT_SECRET,
            'grant_type'     => 'client_credentials',
        ]);

        if (!$tokenResponse->successful()) {
            return response()->json(['error' => 'Failed to get access token'], 500);
        }

        $accessToken = $tokenResponse->json()['access_token'] ?? null;
        if (!$accessToken) {
            return response()->json(['error' => 'Access token missing'], 500);
        }

        // Step 2: Call PhonePe v2 status API
        // https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/{merchantOrderId}/status


        $statusUrl = rtrim($this->PHONEPE_CHECKOUT_BASEURL, '/')
                     . "/v2/order/{$order->txn_id}/status?details=false";

        $response = Http::withHeaders([
            'Authorization' => 'O-Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->get($statusUrl);

        $data = $response->json();


        // ... after fetching $data from PhonePe API

        Payment::updateOrCreate(
            [
                'order_id' => $order->id,
                'transaction_id' => $data['paymentDetails'][0]['transactionId'] ?? 'COD-'.$order->id,
            ],
            [
                'payment_type'    => 'PhonePe',
                'status'          => $data['state'] ?? null,
                'amount'          => $data['amount'] ?? null,
                'payment_mode'    => $data['paymentDetails'][0]['paymentMode'] ?? null,
                'payment_details' => $data
            ]
        );



        // Step 3: Update order status if present
        if (isset($data['status'])) {
            $order->order_status = $data['status'];
            $order->save();
        }

        return response()->json($data, $response->status());
    }



}

