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


        if($this->env=="prod")
        {

            return $this->payment($request, $order_id);
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



public function createPayment_production(Request $request, $order_id)
{
    $order = Order::findOrFail($order_id);

    $merchantId  = env('PHONEPE_MERCHANT_ID');
    $saltKey     = env('PHONEPE_SALT_KEY');
    $saltIndex   = env('PHONEPE_SALT_INDEX');
    $baseUrl     = env('PHONEPE_CHECKOUT_BASEURL'); // e.g. https://api.phonepe.com/apis/hermes

    $merchantTransactionId = "TXN-" . $order->id . "-" . rand(1000,9999);

    $payload = [
        "merchantId"   => $merchantId,
        "merchantTransactionId" => $merchantTransactionId,
        "merchantUserId" => "MUID-" . $order->id,
        "amount"       => $order->total_amount * 100, // in paise
        "redirectUrl"  => route('phonepe.success', ['txn_id' => $merchantTransactionId]),
        "callbackUrl"  => route('phonepe.callback'),
        "paymentInstrument" => [
            "type" => "PAY_PAGE"
        ]
    ];

    $payloadJson = json_encode($payload);
    $base64Payload = base64_encode($payloadJson);

    // Generate checksum (X-VERIFY)
    // API path https://api.phonepe.com/apis/pg/checkout/v2/pay
    $endpoint = "/v2/pay";

    $apiPath = "/pg/v2/pay";  // For checksum only
    $checksum = hash("sha256", $base64Payload . $apiPath . $saltKey) . "###" . $saltIndex;


    $response = Http::withHeaders([
        "Content-Type" => "application/json",
        "X-VERIFY"     => $checksum,
        "X-MERCHANT-ID"=> $merchantId
    ])->post("https://api.phonepe.com/apis/pg/v2/pay", [
        "request" => $base64Payload
    ]);


    $data = $response->json();

    if (isset($data['data']['instrumentResponse']['redirectInfo']['url'])) {
        return redirect($data['data']['instrumentResponse']['redirectInfo']['url']);
    }

    return $data;
}


public function payment(Request $request, $order_id)
    {

        $order = Order::findOrFail($order_id);

        $amount =  $order->total_amount;
        $name   =  $order->customer->name;
        $email  = $order->customer->email ?? "noemail@webtechindia.com";
        $phone  = $order->customer->phone;



        // Get PhonePe credentials from .env
        $merchantId   = env('PHONEPE_MERCHANT_ID');
        $apiKey       = env('PHONEPE_SALT_KEY');




        $merchantOrderId = "PhonePe-".$order->id."-".time();

        // Save transaction ID in order record
        $order->payment_mode="PhonePe";
        $order->txn_id = $merchantOrderId;
        $order->order_status="PENDING";
        $order->save();


        $salt_index   = env('PHONEPE_SALT_INDEX', 1);
        $redirectUrl = route('phonepe.success', ['txn_id' => $merchantOrderId]);

       // $redirectUrl = "https://www.avghealthcare.com/phonepe/";
        // Unique Order ID
        $order_id = uniqid();

        // Prepare transaction data
         $transaction_data = [
            'merchantId'            => $merchantId,
            'merchantTransactionId' => $merchantOrderId,
            'merchantUserId'        => $order->customer->email,
            'amount'                => $amount * 100, // Convert to paise
            'redirectUrl'           => $redirectUrl,
            'redirectMode'          => "POST",
            'callbackUrl'           => $redirectUrl,
            'paymentInstrument'     => [
                'type' => "PAY_PAGE",
            ]
        ];

        $encoded      = json_encode($transaction_data);
        $payloadMain  = base64_encode($encoded);
        $payload      = $payloadMain . "/pg/v1/pay" . $apiKey;

        $sha256       = hash("sha256", $payload);
        $final_x_header = $sha256 . '###' . $salt_index;
        $json_request = json_encode(['request' => $payloadMain]);

        // Choose endpoint based on environment
        $url =  "https://api.phonepe.com/apis/hermes/pg/v1/pay";

     // upgrade the code to work with :
    //  $url = "https://api.phonepe.com/apis/pg/checkout/v2/pay";

        // cURL call
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $json_request,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "X-VERIFY: " . $final_x_header,
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['error' => 'cURL Error: ' . $err], 500);
        }

       $res = json_decode($response);
       $payUrl = $res->data->instrumentResponse->redirectInfo->url;
       return redirect($payUrl);


        if (isset($res->code) && $res->code === 'PAYMENT_INITIATED') {
            $payUrl = $res->data->instrumentResponse->redirectInfo->url;
            return redirect()->away($payUrl);
        }

        return response()->json(['error' => 'Transaction Error', 'details' => $res], 400);
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


    public function payment_new(Request $request, $order_id)
{
    $order = Order::findOrFail($order_id);

    $amount = $order->total_amount;
    $name   = $order->customer->name;
    $email  = $order->customer->email ?? "noemail@webtechindia.com";
    $phone  = $order->customer->phone;

    // Get PhonePe credentials from .env
    $merchantId  = env('PHONEPE_MERCHANT_ID');
    $saltKey     = env('PHONEPE_SALT_KEY');     // 👈 Correct: Salt key
    $saltIndex   = env('PHONEPE_SALT_INDEX', 1);

    $merchantOrderId = "PhonePe-" . $order->id . "-" . rand(1000, 9999);

    // Save transaction ID in order record
    $order->payment_mode = "PhonePe";
    $order->txn_id       = $merchantOrderId;
    $order->order_status = "PENDING";
    $order->save();

    $redirectUrl = route('phonepe.success', ['txn_id' => $merchantOrderId]);

    // Prepare transaction data
    $transaction_data = [
        'merchantId'            => $merchantId,
        'merchantTransactionId' => $merchantOrderId,
        'merchantUserId'        => $email,
        'amount'                => $amount * 100, // Convert to paise
        'redirectUrl'           => $redirectUrl,
        'redirectMode'          => "POST",
        'callbackUrl'           => $redirectUrl,
        'paymentInstrument'     => [
            'type' => "PAY_PAGE",
        ]
    ];

    // Encode payload
    $encoded     = json_encode($transaction_data, JSON_UNESCAPED_SLASHES);
    $payloadMain = base64_encode($encoded);

    // Endpoint (without domain)
    $endpoint = "/pg/v1/pay";

    // ✅ Correct checksum calculation
    $stringToHash   = $payloadMain . $endpoint . $saltKey;
    $sha256         = hash("sha256", $stringToHash);
    $final_x_header = $sha256 . "###" . $saltIndex;

    $json_request = json_encode(['request' => $payloadMain]);

    // ✅ Production endpoint
    $url = "https://api.phonepe.com/apis/pg/checkout/v2/pay";

    // cURL call
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     => $json_request,
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json",
            "X-VERIFY: " . $final_x_header,
            "X-MERCHANT-ID: " . $merchantId,   // Required for v2
            "accept: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return response()->json(['error' => 'cURL Error: ' . $err], 500);
    }

    $res = json_decode($response);

    if (isset($res->code) && $res->code === 'PAYMENT_INITIATED') {
        $payUrl = $res->data->instrumentResponse->redirectInfo->url;
        return redirect()->away($payUrl);
    }

    return response()->json(['error' => 'Transaction Error', 'details' => $res], 400);
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

