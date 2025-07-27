<?php 

namespace App\Services\Payments;

use Illuminate\Http\Request;
use Khalti\KhaltiLaravel\Khalti;

class IMEPayService implements PaymentGatewayInterface
{
    public function initiate(Request $request, string $purpose)
    {
        $amount = match ($purpose) {
            'certificate' => 50000,
            'exam' => 100000,
            default => abort(400, 'Unknown payment purpose'),
        };

        $khaltiRequest = new Request([
            'return_url' => route('student.payment.callback', ['gateway' => 'khalti', 'purpose' => $purpose]),
            'website_url' => config('app.url'),
            'amount' => $amount,
            'purchase_order_id' => uniqid(),
            'purchase_order_name' => ucfirst($purpose) . ' Payment',
        ]);

        $response = Khalti::ePaymentInitiateRequest($khaltiRequest);

        return isset($response['payment_url'])
            ? redirect($response['payment_url'])
            : back()->withErrors(['msg' => 'Failed to initiate Khalti payment.']);
    }

    public function callback(Request $request, string $purpose)
    {
        $pidx = $request->query('pidx');
        $status = $pidx ? Khalti::ePaymentLookup($pidx) : null;

        if (($status['status'] ?? '') === 'Completed') {
            // You can redirect to a purpose-specific confirmation route
            return redirect()->route('student-dashboard')->with('success', "$purpose payment successful.");
        }

        return redirect()->route('student-dashboard')->with('error', "$purpose payment failed.");
    }
}
