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

        $order = Order::find($order_id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        // 🔄 Step 1: Verify payment status before creating a new payment
        $verifyResponse = $this->verifyPayment($request, $order->txn_id);

        // If verifyPayment returns a proper JsonResponse, convert to array
        if ($verifyResponse instanceof \Illuminate\Http\JsonResponse) {
            $verifyData = $verifyResponse->getData(true);

            $status = $verifyData['state'] ?? $verifyData['paymentDetails'][0]['state'] ?? null;

            if ($status === 'COMPLETED') {
                // ✅ Already paid → redirect to order status page
                return redirect()->route('order_status', ['txn_id' => $order->txn_id])
                                 ->with('message', 'Order already completed.');
            }
        }

        // 🔑 Step 2: Get access token


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
           // $merchantOrderId = "TX".$order->id;


            $merchantOrderId = "PhonePe-".$order->id."-".rand(1000,9999);

            // Save transaction ID in order record
            $order->payment_mode="PhonePe";
            $order->txn_id = $merchantOrderId;
            $order->order_status="PENDING";
            $order->save();
            $redirectUrl = route('phonepe.success', ['txn_id' => $merchantOrderId]);

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


    public function cod_success(Request $request, $txn_id)
    {

        $order = Order::where('txn_id', $txn_id)->first();

        if ($order === null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Error: Order Session is invalid'
            ], 404);
        }

        Payment::updateOrCreate(
            [
                'order_id' => $order->id,
                'transaction_id' => null,
            ],
            [
                'payment_type'    => 'COD',
                'status'          => "DUE",
                'amount'          => $order->total_amount*100, //paise
                'payment_mode'    => "CASH",
                'payment_details' => null
            ]
        );



        // Step 3: Update order status if present
        $order->order_status = "COMPLETED";
        $order->save();

        return redirect()->route('order_status', ['txn_id' => $txn_id]);


    }


    public function success(Request $request, $txn_id)
    {
        // Verify payment via PhonePe
        $response = $this->verifyPayment($request, $txn_id);

        // If verifyPayment() already updates the order status, no need to do it again
        if ($response->getStatusCode() !== 200) {
            return $response; // Return error JSON
        }

        $data = $response->getData(true); // Convert JsonResponse to array
        $order = Order::where('txn_id', $txn_id)->first();

        if ($order === null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Error: Order TXN ID is invalid'
            ], 404);
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

           // $request->session()->put('order_id', $id);
           // $request->session()->put('order_status', $status);

            return redirect()->route('order_status', ['txn_id' => $txn_id]);


        //return response()->json($data); // Return the verification response
    }


    public function verifyPayment(Request $request, $txn_id)
    {
        $order = Order::firstWhere('txn_id', $txn_id);

        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Transaction not found',
            ], 404);
        }

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
                'transaction_id' => $data['paymentDetails'][0]['transactionId'] ?? null,
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
        if (isset($data['state'])) {
            $order->order_status = $data['state'];
            $order->save();
        }

        return response()->json($data, $response->status());
    }



}

