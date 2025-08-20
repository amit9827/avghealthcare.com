<?php

namespace App\Http\Controllers;

use Yogeshgupta\PhonepeLaravel\Facades\PhonePe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Initiate a PhonePe payment.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function initiate(Request $request)
    {


        // Validate request data
          $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100', // Minimum amount in paisa (1 INR)
            'order_id' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            Log::error('Payment initiation failed: Invalid request data', ['errors' => $validator->errors()]);
            return back()->withErrors($validator)->withInput();
        }


        $orderId = (string) $request->input('order_id'); // Ensure order_id is a string
        $amount = (int) ($request->input('amount') * 100); // Convert to paisa

        // For testing, we can hardcode the values
        // $orderId = 'test_order_id_12345'; // Example order ID
        // $amount = 10000; // Example amount in paisa (100 INR)

        // Prepare payload
         $payload = [
            'merchantOrderId' => uniqid(),
            'amount' => $amount,
            'expireAfter' => 1200,
            'metaInfo' => [
                'udf1' => 'subscription_payment',
                'udf2' => 'order_id_' . $orderId,
                'udf3' => 'student_checkout',
                'udf4' => '',
                'udf5' => '',
            ],
        ];

        try {
            $result = PhonePe::initiatePayment($amount, $orderId, $payload);

            if ($result['success']) {
                if ($request->ajax()) {
                    return response()->json(data: $result);
                }
                return redirect($result['redirectUrl']);
            }

            Log::error('Payment initiation failed', [
                'order_id' => $orderId,
                'error' => $result['error'],
            ]);
            return back()->withErrors(['error' => 'Payment initiation failed: ' . $result['error']]);
        } catch (\Exception $e) {
            Log::error('Unexpected error during payment initiation', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unexpected error: ' . $e->getMessage(),
                ], 500);
            }
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    /**
     * Verify a PhonePe payment status.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'merchantOrderId' => 'required|string|min:1|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Payment verification failed: Invalid merchantOrderId', [
                'errors' => $validator->errors()->toArray(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'error' => 'Invalid merchantOrderId',
                'details' => $validator->errors()->toArray(),
            ], 400);
        }

        $merchantOrderId = $request->input('merchantOrderId');

        try {
            $result = PhonePe::verifyPhonePePayment($merchantOrderId);

            if ($result['success']) {
                Log::info('Payment status retrieved successfully', [
                    'merchantOrderId' => $merchantOrderId,
                    'data' => $result['data'],
                ]);
                return response()->json($result['data']);
            }

            Log::error('Payment verification failed', [
                'merchantOrderId' => $merchantOrderId,
                'error' => $result['error'],
            ]);
            return response()->json([
                'error' => 'Payment verification failed',
                'details' => $result['error'],
            ], 400);
        } catch (\Exception $e) {
            Log::error('Unexpected error during payment verification', [
                'merchantOrderId' => $merchantOrderId,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'error' => 'An unexpected error occurred',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
