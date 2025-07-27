<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Certificate\CertificateIssuanceStoreRequest;
use App\Http\Requests\Api\Certificate\CertificateRenewStoreRequest;
use App\Http\Requests\Api\OnlinePayment\FindNewCertUserRequest;
use App\Http\Requests\Api\OnlinePayment\FindUserRequest;
use App\Services\Api\OnlinePaymentService;

class OnlinePaymentController extends Controller
{
    protected OnlinePaymentService $service;

    public function __construct(OnlinePaymentService $service)
    {
        $this->service = $service;
    }

    public function test()
    {
        return response()->json([
            'status'      => 200,
            'message'     => 'API is working correctly.',
            'api_version' => 'v1',
            'data'        => [
                'server_status' => 'online', // Assuming the server is online
                'api_status'    => 'active', // Assuming the API is active
            ],
        ], 200);
    }

    public function fetchUser(FindUserRequest $request)
    {
        return $this->service->findUser($request->validated());
    }
    public function fetchNewCertUser(FindNewCertUserRequest $request)
    {
        return $this->service->findNewCertUser($request->validated());
    }
    public function certificateRenewStore(CertificateRenewStoreRequest $request)
    {
        return $this->service->certificateRenewStore($request->validated());
    }

    public function certificateIssuanceStore(CertificateIssuanceStoreRequest $request)
    {
        return $this->service->certificateIssuanceStore($request->validated());
    }

}
