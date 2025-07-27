<?php

namespace App\Http\Controllers\Council;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Services\Council\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(protected CertificateService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createTslc(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Generate Certificate';
        return view('council.certificate.tslc_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function moveTslcToDarta(Request $request)
    {
        $this->service->generateCertificate($request);
    }

    
    public function createCertificate(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Generate Certificate';
        return view('council.certificate.form', $data);
    }

    public function moveToDarta(Request $request)
    {
        $this->service->generateCertificate($request);
    }

    public function dartaList(Request $request)
    {
        $data['nav'] = 'darta';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Darta List';
        $data['date'] = $request->date ?? '';
        $data['dates'] = Certificate::select('decision_date')
        ->distinct()->orderBy('id', 'desc')
        ->get();
        $per_page = 50;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->dartaList($per_page, $page, $data['q'],$data['date']);
        return view('council.certificate.darta_list', $data);
    }

    public function dartaDetail(Request $request)
    {
        $data['nav'] = 'darta';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Darta Detail List';
        $data['date'] = $request->decision_date;
        $data['program_id'] = $request->program_id;
        // dd($data);
        $per_page = 50;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->dartaDetail($per_page, $page, $data['q'],$data['date'], $data['program_id']);
        return view('council.certificate.darta_detail_list', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $Certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $Certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $Certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $Certificate)
    {
        //
    }
}
