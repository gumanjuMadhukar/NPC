@extends('email.layout')
@section('content')
    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
        <tbody>
            <tr>
                <td style="background: #f15a0e; padding: 30px; border-top-right-radius: 16px; border-top-left-radius: 16px;">
                    <h1
                        style="
                        text-align: center;
                        font-family: 'Red Hat Display', sans-serif;
                        font-size: 24px;
                        font-weight: 500;
                        line-height: 32px;
                        color: #fff;
                        padding-bottom: 20px;
                      ">
                        Dear {{ $name }}</h1>
                    <p
                        style="
                        color: #fff;
                        font-family: 'Red Hat Display', sans-serif;
                        font-size: 16px;
                        font-style: normal;
                        font-weight: 400;
                        line-height: 21.5px;
                      ">
                        This email is to inform you that your application form has been reviewed and forwarded to Officer.
                        Please login your profile in exam.nhpc.gov.np and check your status.<br>
                        तपाईँले नाम दर्ता परीक्षाको लागि परिषद्को अनलाइन माध्यमबाट दिनुभएको आवेदन फारम चेकजाँचगर्दा परिषदले
                        माग गरे अनुसारको आवश्यक कागजात ठिक भएकोले अर्को प्रक्रिया अगाडि बढाएको जानकारी गराउँदछौँ | साथै
                        exam.nhpc.gov.np गएर तपाईँले दिनुभएको अवेदनको प्रक्रियाबारे जानकारी पाउन सक्नुहुनेछ। <br>
                        धन्यवाद
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="background-color: #faffe1; padding: 32px; border-bottom-right-radius: 16px; border-bottom-left-radius: 16px;">
                    <p
                        style="
                      color: #1b1d1f;
                      font-family: 'Red Hat Display', sans-serif;
                      font-size: 14px;
                      font-style: normal;
                      line-height: 30px;
                      padding-bottom: 16px;
                    ">
                        Thank you for your timely submission. If you have any further questions, feel free to reach out.<br>
                        तपाईंको समयमै फारम submission लागि धन्यवाद। यदि तपाइँसँग कुनै थप प्रश्नहरू छन् भने, सम्पर्क गर्न
                        नहिचकिचाउनुहोस्।

                    </p>
                    <p
                        style="
                      font-family: 'Inter', sans-serif;
                      font-size: 14px;
                      font-style: normal;
                      font-weight: 400;
                      line-height: 24px;
                      padding-top: 16px;
                      padding-inline: 10px;
                    ">
                        <b>Best regards,</b><br />
                        Nepal Health Professional Council<br />
                        Phone: 977-1-4373118, 1-4375079 <br />
                        Email: admin@nhpc.gov.np<br /> </p>
                    <br />
                </td>
            </tr>
        </tbody>
    </table>
@endsection
