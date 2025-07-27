@extends('email.layout')
@section('content')
<table cellpadding="0" cellspacing="0" role="presentation" width="100%">
    <tbody>
        <tr>
            <td
                style="background: #f15a0e; padding: 30px; border-top-right-radius: 16px; border-top-left-radius: 16px;">
                <h1 style="
                        text-align: center;
                        font-family: 'Red Hat Display', sans-serif;
                        font-size: 24px;
                        font-weight: 500;
                        line-height: 32px;
                        color: #fff;
                        padding-bottom: 20px;
                      "> Dear {{ $name}}</h1>
                <p style="
                        color: #fff;
                        font-family: 'Red Hat Display', sans-serif;
                        font-size: 16px;
                        font-style: normal;
                        font-weight: 400;
                        line-height: 21.5px;
                      "> Thank you for submitting your application form. After careful review, we regret to inform you
                    that your application has been returned to you due to insufficient documentation.</p>
            </td>
        </tr>
        <tr>
            <td
                style="background-color: #faffe1; padding: 32px; border-bottom-right-radius: 16px; border-bottom-left-radius: 16px;">
                <p style="
                      color: #1b1d1f;
                      font-family: 'Red Hat Display', sans-serif;
                      font-size: 14px;
                      font-style: normal;
                      line-height: 30px;
                      padding-bottom: 16px;
                    "> The following remarks were noted by the application form operator:

                </p>
                <p style="
                      color: #1b1d1f;
                      font-family: 'Red Hat Display', sans-serif;
                      font-size: 14px;
                      font-style: normal;
                      line-height: 30px;
                      padding-bottom: 16px;
                    ">{{$remarks}}
                </p>
                <p style="
                      color: #1b1d1f;
                      font-family: 'Red Hat Display', sans-serif;
                      font-size: 14px;
                      font-style: normal;
                      line-height: 30px;
                      padding-bottom: 16px;
                    ">Please update your profile in a timely manner. If you have any questions or would like further
                    feedback, please feel free to contact us.

                </p>
                <p style="
                      font-family: 'Inter', sans-serif;
                      font-size: 14px;
                      font-style: normal;
                      font-weight: 400;
                      line-height: 24px;
                      padding-top: 16px;
                      padding-inline: 10px;
                    "> <b>Best regards,</b><br />
                    Nepal Health Professional Council<br />
                    Phone: 977-1-4373118, 1-4375079 <br />
                    Email: admin@nhpc.gov.np<br /> </p>
                <br />
            </td>
        </tr>
    </tbody>
</table>
@endsection
