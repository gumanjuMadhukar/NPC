<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KhaltiController extends Controller
{
    public function __construct()
    {
    }
    public function paymentRequest(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "return_url": "http://localhost/nhpc_app_new/student/payment/responses",
        "website_url": "http://localhost/nhpc_app_new/",
        "amount": "1000",
        "purchase_order_id": "Order01",
            "purchase_order_name": "test",

        "customer_info": {
            "name": "Test Bahadur",
            "email": "test@khalti.com",
            "phone": "9800000001"
        }
        }

        ',
        CURLOPT_HTTPHEADER => array(
            'Authorization: key 2ef9461c734d474ea52d6ecdda4fcbcc',
            'Content-Type: application/json',
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response_array = json_decode($response);
        // echo $response;
        $pidx = $response_array->pidx;
        $payment_url = $response_array->payment_url;
        $expires_at = $response_array->expires_at;
        $expires_in = $response_array->expires_in;
        return redirect($payment_url);
    }

    public function paymentResponse(Request $request){
        $pidx = $request['pidx'];
        $transaction_id = $request['transaction_id'];
        $status = $request['status'];
        $total_amount = $request['status'];
        $fee = $request['fee'];
        $refund = $request['refund'];
        $purchase_order_id = $request['purchase_order_id'];

        dd($pidx);
    }
}