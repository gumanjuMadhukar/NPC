<?php 

namespace App\Services\Payments;

use Illuminate\Http\Request;

class EsewaService implements PaymentGatewayInterface
{
    public function initiate(Request $request)
    {
        // Redirect to eSewa payment gateway
    }

    public function callback(Request $request)
    {
        // Verify eSewa response and redirect accordingly
    }
}
