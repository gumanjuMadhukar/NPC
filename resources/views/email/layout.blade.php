<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body
    style="font-family:'Red Hat Display', sans-serif; font-size:14px;  font-style:normal; margin-left:auto; margin-right:auto; margin-top:auto; margin-bottom:auto; background-color:#fff;">
    <table role="presentation" cellspacing="0" cellpadding="0"
        style=" background:#fff; margin-left: auto; margin-right: auto; max-width: 640px; border-style: none;">
        <tbody>
            <tr style="background: #fff">
                <td style="padding-top: 30px;"><a href="{{env('APP_URL')}}" target="_blank"> <img width="150"
                            height="auto" src="{{asset('assets/email/logo.jpg') }}"
                            style=" display: block; outline: none; border: none; text-decoration: none; margin-left: auto; margin-right: auto; margin-bottom: 20px; " />
                    </a></td>
            </tr>
            <tr>
                <td style="border: 1px solid #fde293; border-radius: 16px;">
                    @yield('content')
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%" style="padding:15px;">
                        <tbody>
                            <tr>
                                <td
                                    style="color: #000; text-align: center; font-family: 'Inter', sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 16px; padding-top: 12px;">
                                    Copyright &copy; {{ date('Y') }} Nepal Health Professional Council</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>