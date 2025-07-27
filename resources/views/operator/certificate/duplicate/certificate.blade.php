@extends('operator.layout')
@section('content')
    @php

        [$province, $district, $municipality, $ward_no] = explode(':', $certificate->address);
        [$cert_program, $board_university, $passed_year] = explode(':', $certificate->qualification);

    @endphp
    <style>
        page {
            background: white;
            display: block;
            margin: 10px auto;
            margin-bottom: 0.5cm;
            color: black !important;
        }

        page[size="A4"] {
            width: 25cm;
            height: 29.7cm;
        }

        .cert_name span {
            padding: 2px 5px;
            background-color: blue;
            color: white;
        }
    </style>

    <div class="button" style="margin-top: 100px; margin-left: 300px">
        <button onclick="printDiv()" class="btn btn-primary">Print Certificate</button>
    </div>

    <page size="A4" id="printContent"
        style="width: 21cm;
        height: 29.7cm;
        font-family: 'Arial Black';
        ">
        <div class="printLayout" style="padding: 2.5rem 2rem;">
            <div class="header" style="text-align: center; font-weight: 500;">
                <span class="p" style="font-size: 22px;font-weight: 700;">Schedule -3 <br>
                    (Relating to sub rule (1) of Rule 10)
                </span>
                <h3 style="margin-top: 5px;font-size: 40px;font-weight: 700;line-height: 0.9;">
                    Nepal Health Professional Council <br>
                    <span style="font-weight: 700;         font-size: 22px !important;">Bansbari, Kathmandu, Nepal</span>
                </h3>
            </div>

            <div id="container"
                style=" margin-top: 22px;display: flex;justify-content: space-between; align-items: center;">
                <div class="col-side" id="col1"
                    style="        flex: 0 0 122px;  width: 22px !important;height: 122px;border: 1px solid black;display: flex;justify-content: center;align-items: center;">
                    <img src="{{ $certificate->user->info->getFullProfilePictureAttribute() }}" height="120">
                </div>
                <div class="col cert_name" id="col2"
                    style="
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                    font-size: 26px;
                    font-weight: 600;
                    letter-spacing: 2px;
                    text-align:center;font-family:'Material Design Icon';">
                    <span>Foreign Citizen</span>
                    <span>Temporary</span>
                    <span>Registration Certificate</span>
                </div>

                <div class="col-side" id="col3"
                    style="flex: 0 0 122px;width: 22px !important;
                            height: 122px;
                            border: 1px solid black;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                                  ">
                    Photo</div>
            </div>

            <p class="body"
                style=" text-align: justify;
                    font-weight: 600;
                    font-size: 20px;
                    margin-top: 50px;
                    line-height: 1;
                    ">
                Pursuant to the decision dated
                <span style="font-size: 23px;">{{ date('d-m-Y', strtotime($certificate['decision_date'])) }}</span>
                of the Council, the name of
                <span style="font-size: 25px;
                 font-weight: 600;">
                    {{ ucwords(strtolower($certificate->user['name'])) }}</span> date of birth
                {{ $certificate->user->info->dob_nep }}
                a resident ward No. <span
                    style="font-size: 25px;
                     font-weight: 700;">{{ $certificate->user->info->ward_no }}</span>
                of
                <span
                    style="font-size: 25px;
                     font-weight: 700;">{{ @$certificate->user->info->municipality['name'] }}</span>
                Metropolitan City /Sub-Metropolitan City /Municipality /Rural Municipality
                <span
                    style="font-size: 25px;
        font-weight: 700;">{{ @$certificate->user->info->district['name'] }}</span>
                District <span
                    style="font-size: 25px;
        font-weight: 700;">{{ @$certificate->user->info->province['name'] }}</span>

                Province is registered as <span style="font-size: 25px;
        font-weight: 700;">
                    {{ $certificate->program_certificate_code }}
                </span>
                of <span style="font-size: 25px;
        font-weight: 700;">{{ $certificate->level->name }}</span>
                Level
                in the registration book and this Registration Certificate is hereby
                issued in accordance with subsection (4) of section 17 of the Nepal
                Health Professional Council Act, 2053 B.S. (1997 A.D.) and Rule 10 of the Nepal Health Professional
                Council Rules 2056 B.S. (1999 A.D.)
            </p>

            <div class="" style="height: 130px; display: flex;
       ">
                <div class="left"
                    style="font-weight: 700; line-height: 1.2;   text-align: left;
                            font-size:16px ;
                            width:58%;">
                    Registration No: <span style="font-size: 24px;
">
                        {{ $certificate->cert_registration_number }}</span><br>
                    Date of issue: <span style="        font-size: 24px;
            ">
                        {{ date('d-m-Y', strtotime($certificate['issued_date'])) }}</span><br>
                    Seal of the Council:
                </div>
                <div class="right"
                    style="font-weight: 600;
                            margin-top: 24px;
                            text-align: center;
                            font-size:22px ;
                            padding-left:15px;
                            line-height: 1;
                            float: right;
                            width:42%">
                    <span style="font-size:20px; margin-right: 190px;">Signature:</span> <br>Name: <span
                        style="font-weight: 700; font-size: 20px;
                    ">{{ $certificate['registrar'] }}</span>
                    <br>
                    <span style="font-weight: 700; font-size: 20px;">Registrar</span>

                </div>
            </div>

            <div class="" style="text-align: center; margin-top: 30px;">
                <span style="text-align: center; font-weight: bold; font-size: 14px;">Descriptions of Qualifications /
                    Degree</span>
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

">Qualification
                    </th>
                    <th style="
        text-align: center;font-size:14px ;
        font-weight: bold;

">Institution /
                        University / Board</th>
                    <th style="
        text-align: center; font-size:14px ;
        font-weight: bold;


">Passed Year</th>
                </tr>
                <tr style="
        text-align: center;

">
                    <td
                        style=" border: 1px solid black;
        text-align: center;  font-size: 20px;
        font-weight: bold;
        width: 30px;

">
                        1</td>
                    <td
                        style=" border: 1px solid black;
        text-align: center;  font-size: 20px;
        font-weight: bold;
        width: 200px;

">
                        {{-- {{ @$certificate->program['code'] }} --}}

                        {!! nl2br($cert_program) !!}
                        {{-- @php
    $program = @$certificate->program['code'];

@endphp --}}

                    </td>
                    <td
                        style=" border: 1px solid black;
        text-align: center;  font-size: 20px;
        font-weight: bold;
        width: 200px;

">
                        {{ $board_university }}
                    </td>
                    <td
                        style=" border: 1px solid black;
        text-align: center;  font-size: 19px;
        font-weight: bold;
        width: 80px;

">
                        {{ $passed_year }}</td>
                </tr>

            </table>

            <hr style=" margin-top: 45px;
        border: 1px solid black;">
            <div class="" style="text-align: center;">
                <span style="text-align: center; font-weight: 600; font-size: 16px; word-spacing: 1.6;">Note: - This
                    certificate should be updated in {{ $certificate->duration }}, from the date of issue.</span>
            </div>
        </div>
    </page>


    <script>
        function printDiv() {
            var divContents = document.getElementById("printContent").innerHTML;
            var printWindow = window.open('', '', 'height=1000,width=700');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            a.document.write(divContents.outerHTML);
        }
    </script>
@endsection
