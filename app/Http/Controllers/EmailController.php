<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Send Order Confirmation Email
     */



    public function sendOrderConfirmation($data)
    {

        $order = $data['order'];
        $payment = $data['payment'];

        $to = $order->customer->email;

        if($order==null)
        return null;

        if(env('APP_ENV')== "staging")
        $to = "query@webtechindia.com";


        $subject = "Order Confirmation - {$order->txn_id}";

        // Render Blade into HTML
        $html = view('emails.order_confirmation', compact('data'))->render();

        Mail::html($html, function ($mail) use ($to, $subject) {
            $mail->to($to)->subject($subject);
        });
    }

    public function sendGeneric($to, $subject, $view, $data = [])
    {
        $html = view($view, $data)->render();
        if(env('APP_ENV')== "staging")
        $to = "query@webtechindia.com";
        Mail::html($html, function ($mail) use ($to, $subject) {
            $mail->to($to)->subject($subject);
        });
    }
}
