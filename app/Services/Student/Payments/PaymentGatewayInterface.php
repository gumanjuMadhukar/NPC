<?php

namespace App\Services\Student\Payments;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function initiate(Request $request, string $purpose);
    public function callback(Request $request, string $purpose);
}
