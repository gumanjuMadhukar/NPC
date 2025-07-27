@php use SimpleSoftwareIO\QrCode\Facades\QrCode; @endphp
<div class="content" id="admit-card" style="position: relative">
    <div class="button ml-5 " style="display:flex;align-items:baseline;justify-content:center;position: fixed;top: 70px;background: #fff;width: calc(100% - 260px);padding: 10px;z-index: 100;">
        <span class="text-danger mx-2">"!!! Please click this button to print the admit card !!!"</span>
        <button onclick="printDiv()" class="btn btn-primary">Print Admit Card</button>
    </div>
    <div id="print-content" style="">
        <div class="row">
            <div class="col-lg-12 m-b-3">
                <div class="box box-info">
                    <div class="box-body container with-border p-t-1"
                        style="display:flex; justify-content:space-between;">
                        <div class="col-lg-2 pt-3" style="">
                            <img class="img-responsive" width="150" height="150" style="left: 0%; "
                                src="{{ asset('assets/images/logo.jpg') }}">
                        </div>
                        <div class="col-lg-8 text-center align-content-center"
                            style=" text-align: center;line-height: 0.4;">
                            <h1 style = "color: #003893 !important; font-size:41px; font-weight: bold;  word-spacing: 2px;  margin-top: 20px; "
                                class="box-title text-black">नेपाल स्वास्थ्य व्यवसायी परिषद</h1>
                            <h1 style = "color: red !important; font-size:35px; font-weight: bold; word-spacing: 2px;  margin-top: -5px;"
                                class="box-title text-black">Nepal Health Professional Council</h1>
                            <h3 style = "font-size:20px; margin-top: -5px;" class="box-title  text-black">(नेपाल
                                स्वास्थ्य व्यवसायी परिषद ऐन, २०५३ बमोजिम स्थापित)
                            </h3>
                            <h4 style = "font-size:18px; margin-top: -5px; " class="box-title text-black">बांसबारी,
                                काठमाडौं</h4>
                            <h4 style = "font-size: 26px; font-family:Aerial ;margin-top: -5px;"
                                class="box-title text-black">{{ $exam_apply->exam->name_nep }}</h4>
                            <h4 style = "font-size: 26px; font-family:Aerial;margin-top: -10px;"
                                class="box-title text-black">प्रवेश पत्र</h4>
                        </div>
                        <div class="col-lg-2 pt-3 qr">
                            {!! QrCode::size(100)->generate(
                                    $exam_apply->admit_card?->symbol_number,
                            ) !!}
                        </div>
                    </div>
                    <div class="box-body container mt-2">
                        {{-- @if ($exam_apply->admit_card)
                        @if ($exam_apply->admit_card->created_by == 39569)
                            <span>आठौ नाम दर्ता प्रमाण पत्र परीक्षाको प्रवेश पत्र</span>
                        @else
                            <span>
                                चौथो नाम दर्ता प्रमाण पत्र परीक्षाको प्रवेश पत्र</span>
                        @endif
                    @endif --}}
                        <div class="student-admit-card-body mt-3"
                            style="border: 1px solid #000; padding: 20px;height: 500px;">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div style="width:65%; float: left;">
                                        <p>रोल नम्बर<strong style="padding-left:1em;font-size:18px">:
                                                @if ($exam_apply->admit_card)
                                                    {{ $exam_apply->admit_card->symbol_number }}
                                                @else
                                                    Symbol Number Not generated yet
                                                @endif
                                            </strong>
                                        </p>
                                        <p>पर्रीक्षार्थीको नाम <strong><span
                                                    style="padding-left:1em; font-size:20px; text-transform:capitalize;">:
                                                    {{ $exam_apply->user->info->first_name }}
                                                    {{ $exam_apply->user->info->middle_name }}
                                                    {{ $exam_apply->user->info->last_name }}</span></strong></p>
                                        लिङ्ग <span style="padding-left:1em;text-transform:capitalize;">: {{ $exam_apply->user->info->sex }}<p>
                                            </p>
                                            <p>जन्ममिती<span style="padding-left:1em;"> :
                                                    {{ $exam_apply->user->info->dob_nep }} (
                                                    AD :
                                                    {{ $exam_apply->user->info->dob_eng }} ) </span></p>
                                            <p>ठेगाना, फोन नं.<span style="padding-left:1em;">:
                                                    {{ $exam_apply->user->phone }}
                                                </span>
                                            </p>

                                            <p>विषयको नाम <strong style="padding-left:1em; font-size:18px;">:
                                                    {{ $exam_apply->program->name }} - तह :
                                                    {{ $exam_apply->level->short_name_english }}
                                                </strong>
                                            </p>
                                            <p>परीक्षा केन्द्र <span style="padding-left:1em;">: Advance Education &
                                                    Innovative Research Center (AEIRC), Babarmahal, Kathmandu</span>
                                            </p>

                                            <div style="float:left;">परीक्षार्थीको हस्ताक्षर : <br>
                                                <div
                                                    style="border-width: 1px; height: 120px; width:300px; border-style: dashed;">
                                                    <img style="height: 100%;width: 100%;object-fit:contain;object-position:center;"
                                                        src="{{ $exam_apply->user_info?->full_signature_image }}"
                                                        alt="">
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div style="width: 35%; float: left;">
                                        <div style="display:flex;">
                                            <img width="180px;" height="180px"
                                                src="{{ $exam_apply->user->info->full_profile_picture }}">
                                            <div
                                                style="border-style:dashed; border-width: 1px;height: 170px;width: 170px; object-position: 50% 100%; padding:10px; line-height:1.5">
                                                <p style="width:155px">परीक्षाको लागि फाराम भर्दाको पासपोर्ट साइज को फोटो टास गरी हस्ताक्षर गर्नुपर्नेछ।
                                                </p>
                                            </div>

                                        </div>
                                        <!-- <div style="width: 100%;">परीक्षार्थीको हस्ताक्षर : <img width="120px;" height="80px;" src="http://localhost/nhpcwebapp/backend/web"> -->

                                        <div style="height:50px; float:left;">
                                            <div
                                                style="margin-top: -55px;margin-left: -40px; z-index: 99;position: absolute; height: 50px">
                                                <img src="{{ asset('storage/app/public/user/signature_sachip.png') }}"
                                                    class="signature" width="180px" height="85px">
                                            </div>
                                            <div>
                                                ..................................................<br>
                                                सदस्य सचिवको हस्ताक्षर
                                            </div>
                                        </div>
                                        <div style="padding-left: 0%; padding-top: 20px; " class="mt-5">
                                            <table
                                                style="border: 1px solid black; width: 250px; border-collapse: collapse; text-align:center; overflow: auto;">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center; font-size: 10px;">
                                                            औठा छाप</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size: 10px;">
                                                            दाँया</td>
                                                        <td
                                                            style="border: 1px solid black; border-collapse: collapse; text-align:center; font-size: 10px;">
                                                            बायाँ</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="height: 140px; width:140px;border: 1px solid black; border-collapse: collapse; text-align:center">
                                                        </td>
                                                        <td
                                                            style="height: 140px; width:140px;border: 1px solid black; border-collapse: collapse; text-align:center">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="" style="margin-top: 3rem;">
                            <div class="row" style="font-size: 16px; margin-left: 20px;">
                                <h5><strong class="text-bold" style="font-size: 16px;">परीक्षार्थीले पालना गर्नुपर्ने
                                        नियमहरु :</strong></h5>
                            </div>
                            <div class="row" style="font-size: 16px; margin-left: 20px; line-height: 1.3;">
                                <!-- <div class="row" style=" font-size: 20px; margin-left: 20px;"> -->
                                <p>(क) अनलाइन फाराम भर्दा राखेको फोटोको सक्कल फोटो टाँसी तोकेको स्थानमा दस्तखत (दुवै
                                    फोटोमा पर्ने गरी समेत) र प्रस्ट रेखा देखिने औँठा छाप लगाई प्रवेश पत्र तयार गर्नु
                                    पर्दछ । फोटो नटासेको औँठा छाप नलगाएको र तोकेको स्थानमा दस्तखत नगरेको प्रवेशपत्र
                                    मान्य हुनेछैन । परीक्षा दिन नपाएका वा परीक्षा छुटेका परीक्षार्थीको परीक्षा शुल्क
                                    फिर्ता हुने छैन । </p>
                                <p>(ख) प्रवेश पत्र रुजु र सुरक्षा जाँच भएपछि परीक्षार्थीले आफुलाई परीक्षा दिन तोकेको
                                    स्थानमा गई बस्नु पर्नेछ । </p>
                                <p>(ग) परीक्षा शुरु हुनु भन्दा २ घण्टा पहिले परीक्षार्थीले परीक्षा केन्द्रमा उपस्थित भै
                                    सक्नु पर्ने छ । </p>
                                <p>( घ ) परीक्षा शुरु भएको १५ मिनेट भन्दा पछि आउने लाई परीक्षा मा सामेल गराइने छैन ।
                                </p>
                                <p>(ङ) परीक्षा सुरु भएको एक घण्टा अगाडि परीक्षा हल र १ घण्टा अगावै परीक्षा
                                    केन्द्र परिसर छाड्न पाईने छैन ।</p>
                                <p>(च) परीक्षार्थीले अनिवार्य रुपमा सक्कल नागरीकता, राष्ट्रिय परिचय पत्र वा सवारी चालक
                                    प्रमाण पत्र परीक्षा केन्द्रमा ल्याउनु पर्नेछ । </p>
                                <p>(छ) परीक्षा केन्द्रभित्र हुल हुज्जत वा होहल्ला गर्न पाइने छैन । </p>
                                <p>(ज) परीक्षा सञ्चालन गर्ने जिम्मेवारी लिएका सम्पूर्ण व्यक्तिहरूलाई धाक धम्की वा कुटपिट
                                    वा अभद्र व्यवहार गर्न पाइने छैन । </p>
                                <p>(झ) परीक्षा केन्द्रमा हातहतियार वा विस्फोटक पदार्थ ल्याउन पाइने छैन । </p>
                                <p>(ञ) परीक्षा कोठामा किताब, कपी, नोटस, चिट तथा मोवाईल जस्ता विद्युतिय उपकरणहरु,
                                    ब्लुटुथ, कालो चस्मा, क्यालकुलेटर, पेन ड्राइभ ल्याउन पाइने छैन । यदि ल्याएको खण्डमा
                                    हराएमा
                                    वा टुटफुट भएमा परिषद् जिम्मेवारी हुने छैन् । </p>
                                <p>(ट) परीक्षामा यताउति हेर्न, ईसारा गर्न, सार्न, नक्कल गर्न र अन्य परीक्षार्थीसँग
                                    सरसल्लाह समेतका अनुचित काम गर्न पाइने छैन । </p>
                                <p>(ठ) परीक्षा केन्द्रको सम्पत्तिलाई हानी नोक्सानी पुर्याउन पाइने छैन । </p>
                                <p>(ड) माथि उल्लेखित निर्देशन विपरित कार्यगर्ने परीक्षार्थीलाई तोकिए बमोजिमको कानुनी
                                    कारबाहि गरिनेछ । </p>
                                <p style="font-weight : bold !important;">(ढ) परीक्षा को समय १ घण्टा ३० मिनेट, पुर्णाङ्क
                                    १०० र उत्तिर्णाङ्क ५० हुनेछ । </p>
                            </div>
                            <center style="font-size: 16px;">
                                {{-- <h4>परीक्षा केन्द्र : एडभान्स एजुकेशन & ईनोभेटिव रिसर्च सेन्टर ( ए.ई.आइ.आर्.सी ) </h4> --}}
                                <h4>Exam Centre : Advance Education & Innovative Research Centre (AEIRC) , Babarmahal, Kathmandu</h4>
                            </center>
                            <center style="font-size: 16px;">
                                <h4>परीक्षाको मिति र समयको लागि परिषद्को वेवसाईटमा हेर्नुहुन जानकारी गराईन्छ ।</h4>
                            </center>
                        </div>

                    </div>

                    <div style="height: 100px">
                    </div>
                    <div class="box-body container">
                        <div class="box-body container with-border">
                            <div class="" style="display:flex; justify-content:space-between;">
                                <div class="col-lg-2 pt-3" style="">
                                    <img class="img-responsive" width="150" height="150" style="left: 0%; "
                                        src="{{ asset('assets/images/logo.jpg') }}">
                                </div>
                                <div class="col-lg-8 text-center align-content-center"
                                    style=" text-align: center;line-height: 0.4;">
                                    <h1 style = "color: #003893 !important; font-size:41px; font-weight: bold;  word-spacing: 2px;  margin-top: 20px; "
                                        class="box-title text-black">नेपाल स्वास्थ्य व्यवसायी परिषद</h1>
                                    <h1 style = "color: red !important; font-size:35px; font-weight: bold; word-spacing: 2px;  margin-top: -5px;"
                                        class="box-title text-black">Nepal Health Professional Council</h1>
                                    <h3 style = "font-size:20px; margin-top: -5px;" class="box-title  text-black">
                                        (नेपाल
                                        स्वास्थ्य व्यवसायी परिषद ऐन, २०५३ बमोजिम स्थापित)
                                    </h3>
                                    <h4 style = "font-size:18px; margin-top: -5px; " class="box-title text-black">
                                        बांसबारी,
                                        काठमाडौं</h4>
                                    <h4 style = "font-size: 26px; font-family:Aerial ;margin-top: -5px;"
                                        class="box-title text-black">{{ $exam_apply->exam->name_nep }}</h4>
                                    <h4 style = "font-size: 26px; font-family:Aerial;margin-top: -10px;"
                                        class="box-title text-black">प्रवेश पत्र</h4>
                                </div>
                                <div class="col-lg-2 pt-3 qr">
                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate(
                                        'Name : ' .
                                            $exam_apply->user->info->first_name .
                                            $exam_apply->user->info->middle_name .
                                            $exam_apply->user->info->last_name .
                                            'Symbol Number' .
                                            $exam_apply->admit_card?->symbol_number,
                                    ) !!}
                                </div>
                            </div>
                            <div style="display: flex; font-size: 16px; width:1050px">
                                <p style="padding-left:30px;">कार्यालय प्रयोजनको लागि</p>
                                <p style="padding-left:690px">Website: www.nhpc.gov.np</p>
                            </div>
                            <div style="border-style:solid; border-width:1px; padding:5px ; margin-bottom:50px;">

                                <div style="width: 145px; height: 20px; padding-left: 80%;  text-align: center;">

                                    <img width="180px;" height="180px; object-fit: cover; object-position: 50% 100%;"
                                        src="{{ $exam_apply->user->info->full_profile_picture }}">
                                        <div style="height:50px; float:left; position: absolute;z-index:99">
                                            <div
                                                style="margin-top: -60px;height: 50px">
                                                <img src="{{ asset('storage/app/public/user/signature_sachip.png') }}"
                                                    class="signature" width="220px" height="120px">
                                            </div>
                                            <div>
                                                ..................................................<br>
                                                सदस्य सचिवको हस्ताक्षर
                                            </div>
                                        </div>

                                </div>

                                <div class="admit_card" style="font-size: 14px; margin-left: 20px;">
                                    <p>रोल नम्बर<strong style="padding-left:1em;font-size:18px">:
                                            @if ($exam_apply->admit_card)
                                                {{ $exam_apply->admit_card->symbol_number }}
                                            @else
                                                Symbol Number Not generated yet
                                            @endif
                                        </strong>
                                    </p>
                                    <p>पर्रीक्षार्थीको नाम <strong><span style="padding-left:1em; font-size:20px;">:
                                                {{ $exam_apply->user->info->first_name }}
                                                {{ $exam_apply->user->info->middle_name }}
                                                {{ $exam_apply->user->info->last_name }}</span></strong></p>
                                    <p>जन्ममिती<span style="padding-left:1em;"> :
                                            {{ $exam_apply->user->info->dob_nep }}&nbsp;
                                            &nbsp;
                                            &nbsp;( AD : {{ $exam_apply->user->info->dob_eng }} ) </span></p>
                                    <p>ठेगाना, फोन नं.<span style="padding-left:1em;">:
                                            {{ $exam_apply->user->phone }}</span></p>
                                    <p>विषयको नाम <strong style="padding-left:1em; font-size:18px;">:
                                            {{ $exam_apply->program->name }} -  तह :
                                            {{ $exam_apply->level->short_name_english }}
                                        </strong>
                                    </p>
                                    <p>परीक्षा केन्द्र <span style="padding-left:1em;">: Advance Education &
                                        Innovative Research Center (AEIRC), Babarmahal, Kathmandu</span>
                                </p>
                                    <div>परीक्षार्थीको हस्ताक्षर : <br>
                                        <div
                                            style="border-width: 1px; height: 120px; width:300px; border-style: dashed;">
                                            <img style="height: 100%;width: 100%;object-fit:contain;object-position:center;"
                                                src="{{ $exam_apply->user_info?->full_signature_image }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
