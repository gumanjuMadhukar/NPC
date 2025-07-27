<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\College\StoreRequest;
use App\Models\College;
use App\Services\Admin\CertificateService;
// use App\Services\Admin\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(protected CertificateService $service)
    {
    }
    public function migrate_duplicate_certificate()
    {
        $certificates = $this->service->get_old_data();
        // echo '<pre>';
        foreach ($certificates as $certificate) {
            $this->service->add($certificate);
        }

    }
}