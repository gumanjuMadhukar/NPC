@extends('operator.layout')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div>
            <button class="btn btn-primary">Print Certificate</button>
        </div>
        <div class="certificate">
            <div class="inner">

                <input type="hidden" id="certificateID" value="85738">
                <div class="printLayout" style="padding: 2.5rem 2rem;">

                    <div class="header" style="text-align: center; font-weight: 500;">
                        <span class="p" style="font-size: 22px   ;      font-weight: 700;
">Schedule -3 <br>
                            (Relating to sub rule (1) of Rule 10)
                        </span>
                        <h3 style="margin-top: 5px;
        font-size: 40px;
        font-weight: 700;
        line-height: 0.9;">Nepal Health Professional Council <br>
                            <span style="font-weight: 700;         font-size: 22px !important;
">Bansbari, Kathmandu, Nepal</span>
                        </h3>
                    </div>

                    <div id="container" style=" margin-top: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;">

                        <div class="col-side" id="col1" style="        flex: 0 0 122px;  width: 22px !important;
        height: 122px;
        border: 1px solid black;
        margin-right: 22px;
        display: flex;
        justify-content: center;
        align-items: center;
">
                            <img src="/storage/documents/awD7znNvzsBYSMiXI3AYnGQ8D4AS1WHjOIoKgZvg.jpg" height="120">
                        </div>
                        <div class="col" id="col2" style="flex: 2; background-color: blue;
        justify-content: center;
        padding-left: 0.3rem;
        font-size: 30px;
        font-weight: 600;
        border: 2px solid black; color:white  !important;"> Registration Certificate </div>
                        <div class="col-side" id="col3" style="        flex: 0 0 122px;width: 22px !important;
        height: 122px;
        border: 1px solid black;
        margin-left: 22px;
        display: flex;
        justify-content: center;
        align-items: center;
">Photo</div>
                    </div>

                    <p class="body" style=" text-align: justify;
        font-weight: 600;
        font-size: 20px;
        margin-top: 50px;
        line-height: 1;
        ">
                        Pursuant to the decision dated
                        26-04-2023

                        of the Council, the name of
                        <span style="font-size: 26px;
        font-weight: 600;"> {{ $certificate->user->info->first_name}} {{ $certificate->user->info->middle_name }} {{ $certificate->user->info->last_name }}</span> date of birth
                        {{ $certificate->user->info->dob_nep }}
                        a resident ward No. <span style="font-size: 26px;
        font-weight: 700;">{{ $certificate->user->info->ward_no }}</span> of <span style="font-size: 26px;
        font-weight: 700;">{{ $certificate->user->info->Municipality['name'] }}</span>
                        Metropolitan City /Sub-Metropolitan City /Municipality /Rural Municipality
                        <span style="font-size: 26px;
        font-weight: 700;">{{ $certificate->user->info->district['name'] }}</span> District <span style="font-size: 26px;
        font-weight: 700;">{{ $certificate->user->info->province['name'] }}</span>

                        Province is registered as <span style="font-size: 26px;
        font-weight: 700;">

                            {{ $certificate->program_certificate_code }}
                        </span>
                        of <span style="font-size: 26px;
        font-weight: 700;">{{ $certificate->level['short_name_english'] }}</span> Level
                        in the registration book and this Registration Certificate is hereby
                        issued in accordance with subsection (4) of section 17 of the Nepal
                        Health Professional Council Act, 2053 B.S. (1997 A.D.) and Rule 10 of the Nepal Health Professional
                        Council Rules 2056 B.S. (1999 A.D.)
                    </p>

                    <div class="footer" style="height: 130px; display: block;
       ">
                        <div class="left" style="font-weight: 700; line-height: 1.2;   text-align: left;
        font-size:18px ;
        float: left;">
                            Registration No: <span style="        font-size: 26px;
"> {{ $certificate['cert_registration_number'] }}</span><br>
                            Date of issue: <span style="        font-size: 22px;
            ">
                                {{ $certificate['issued_date'] }}




                            </span><br>
                            Seal of the Council:
                        </div>
                        <div class="right" style="font-weight: 600;
        margin-top: 50px;
        text-align: center;
        font-size:22px ;
        line-height: 1;
        float: right;">
                            <span style="font-size:20px; margin-right: 190px;">Signature:</span> <br>
                            Name: <span style="font-weight: 700; font-size: 20px;
            ">{{ $certificate->registrar }}</span> <br>
                            <span style="font-weight: 700; font-size: 20px;">Registrar</span>

                        </div>
                    </div>

                    <div class="footer" style="text-align: center; margin-top: 30px;">
                        <span style="text-align: center; font-weight: bold; font-size: 14px;">Descriptions of Qualifications / Degree</span>
                    </div>
                    <style>
                        table,
                        th,
                        td {
                            border: 1px solid black;
                        }
                    </style>
                    <table style="
        text-align: center; border-collapse: collapse;
        width: 100%;">
                        <tbody>
                            <tr style="
        text-align: center;
">
                                <th style="
        text-align: center; font-size:14px ;
        font-weight: bold;

">S.N</th>
                                <th style="
        text-align: center; font-size:14px ;
        font-weight: bold;

">Qualification</th>
                                <th style="
        text-align: center;font-size:14px ;
        font-weight: bold;

">Institution / University / Board</th>
                                <th style="
        text-align: center; font-size:14px ;
        font-weight: bold;


">Passed Year</th>
                            </tr>
                            <tr style="
        text-align: center;

">
                                <td style=" border: 1px solid black;
        text-align: center;  font-size: 16px;
        font-weight: bold;
        width: 30px;

">1</td>






                                <td style=" border: 1px solid black;
        text-align: center;  font-size: 16px;
        font-weight: bold;
        width: 140px;

">

                                    {{ $certificate->program['qualification'] }}

                                </td>
                                <td style=" border: 1px solid black;
        text-align: center;  font-size: 16px;
        font-weight: bold;
        width: 200px;

">
                                </td>
                                <td style=" border: 1px solid black;
        text-align: center;  font-size: 16px;
        font-weight: bold;
        width: 80px;

">
                                </td>
                            </tr>
                            <tr style=" border: 1px solid black;
        text-align: center;         height: 15px;
">
                                <td style=" border: 1px solid black;
        text-align: center;         padding: 10px;
        height: 15px;
"></td>
                                <td style=" border: 1px solid black;
        text-align: center;         padding: 10px;
"></td>
                                <td style=" border: 1px solid black;
        text-align: center;         padding: 10px;
"></td>
                                <td style=" border: 1px solid black;
        text-align: center;        padding: 10px;
"></td>
                            </tr>
                            <tr style=" border: 1px solid black;
        text-align: center;         padding: 10px;
">
                                <td style=" border: 1px solid black;
        text-align: center;         padding: 10px;
"></td>
                                <td style=" border: 1px solid black;
        text-align: center;         padding: 10px;
"></td>
                                <td style=" border: 1px solid black;
        text-align: center;         padding: 10px;
"></td>
                                <td style=" border: 1px solid black;
        text-align: center;        padding: 10px;
"></td>
                            </tr>
















                        </tbody>
                    </table>

                    <hr style=" margin-top: 45px;
        border: 1px solid black;">
                    <div class="footer" style="text-align: center;">
                        <span style="text-align: center; font-weight: 600; font-size: 16px; word-spacing: 1.6;">Note: - This certificate should be updated in every five years, from the date of issue.</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="statusModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">
            <div class="cardbox"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...</div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
@include('operator.certificate.js.user')
@endsection