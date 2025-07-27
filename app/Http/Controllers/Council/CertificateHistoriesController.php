<?php

namespace App\Http\Controllers\Council;

use App\Http\Controllers\Controller;
use App\Models\CertificateHistories;
use Illuminate\Http\Request;

class CertificateHistoriesController extends Controller
{
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificateHistories $certificateHistories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateHistories $certificateHistories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificateHistories $certificateHistories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateHistories $certificateHistories)
    {
        //
    }
}
