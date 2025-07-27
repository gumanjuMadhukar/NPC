<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('timeElapsed')) {
    function timeElapsed($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

if (!function_exists('youtube')) {
    function youtube($video)
    {
        $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, $video, $matches);
        return (isset($matches[1])) ? $matches[1] : null;
    }
}

if (!function_exists('getMax')) {
    function getMax($table_name, $field_name)
    {
        return DB::table($table_name)->max($field_name) + 1;
    }
}

if (!function_exists('getSlug')) {
    function getSlug($table_name, $field_name, $title, $id = 0, $id_name = 'id')
    {
        $slug_name = Str::slug($title);
        $slug_name = ($slug_name) ? $slug_name : time();
        $row = DB::table($table_name)->where($id_name, '<>', $id)->where($field_name, $slug_name)->first();
        $slug = ($row) ? $slug_name . "-" . DB::table($table_name)->count() + 1 : $slug_name;
        $recheck = DB::table($table_name)->where($id_name, '<>', $id)->where($field_name, $slug)->first();
        if ($recheck) {
            $slug = $slug_name . "-" . time();
        }
        return $slug;
    }
}

if (!function_exists('unique_multidim_array')) {
    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                array_push($temp_array, $val);
                //$temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}

if (!function_exists('convertXmlToArray')) {
    function convertXmlToArray($xml, )
    {
        $xmlString = str_replace(array("\r", "\n"), '', $xml);
        $xml = simplexml_load_string($xmlString, );
        $json = json_encode($xml);
        $array = json_decode($json, true);
        return $array;
    }
}

if (!function_exists('moneyFormat')) {
    function moneyFormat($floatcurr, $curr = 'NPR')
    {
        $currencies['ARS'] = array(2, ',', '.'); //  Argentine Peso
        $currencies['AMD'] = array(2, '.', ','); //  Armenian Dram
        $currencies['AWG'] = array(2, '.', ','); //  Aruban Guilder
        $currencies['AUD'] = array(2, '.', ' '); //  Australian Dollar
        $currencies['BSD'] = array(2, '.', ','); //  Bahamian Dollar
        $currencies['BHD'] = array(3, '.', ','); //  Bahraini Dinar
        $currencies['BDT'] = array(2, '.', ','); //  Bangladesh, Taka
        $currencies['BZD'] = array(2, '.', ','); //  Belize Dollar
        $currencies['BMD'] = array(2, '.', ','); //  Bermudian Dollar
        $currencies['BOB'] = array(2, '.', ','); //  Bolivia, Boliviano
        $currencies['BAM'] = array(2, '.', ','); //  Bosnia and Herzegovina, Convertible Marks
        $currencies['BWP'] = array(2, '.', ','); //  Botswana, Pula
        $currencies['BRL'] = array(2, ',', '.'); //  Brazilian Real
        $currencies['BND'] = array(2, '.', ','); //  Brunei Dollar
        $currencies['CAD'] = array(2, '.', ','); //  Canadian Dollar
        $currencies['KYD'] = array(2, '.', ','); //  Cayman Islands Dollar
        $currencies['CLP'] = array(0, '', '.'); //  Chilean Peso
        $currencies['CNY'] = array(2, '.', ','); //  China Yuan Renminbi
        $currencies['COP'] = array(2, ',', '.'); //  Colombian Peso
        $currencies['CRC'] = array(2, ',', '.'); //  Costa Rican Colon
        $currencies['HRK'] = array(2, ',', '.'); //  Croatian Kuna
        $currencies['CUC'] = array(2, '.', ','); //  Cuban Convertible Peso
        $currencies['CUP'] = array(2, '.', ','); //  Cuban Peso
        $currencies['CYP'] = array(2, '.', ','); //  Cyprus Pound
        $currencies['CZK'] = array(2, '.', ','); //  Czech Koruna
        $currencies['DKK'] = array(2, ',', '.'); //  Danish Krone
        $currencies['DOP'] = array(2, '.', ','); //  Dominican Peso
        $currencies['XCD'] = array(2, '.', ','); //  East Caribbean Dollar
        $currencies['EGP'] = array(2, '.', ','); //  Egyptian Pound
        $currencies['SVC'] = array(2, '.', ','); //  El Salvador Colon
        $currencies['ATS'] = array(2, ',', '.'); //  Euro
        $currencies['BEF'] = array(2, ',', '.'); //  Euro
        $currencies['DEM'] = array(2, ',', '.'); //  Euro
        $currencies['EEK'] = array(2, ',', '.'); //  Euro
        $currencies['ESP'] = array(2, ',', '.'); //  Euro
        $currencies['EUR'] = array(2, ',', '.'); //  Euro
        $currencies['FIM'] = array(2, ',', '.'); //  Euro
        $currencies['FRF'] = array(2, ',', '.'); //  Euro
        $currencies['GRD'] = array(2, ',', '.'); //  Euro
        $currencies['IEP'] = array(2, ',', '.'); //  Euro
        $currencies['ITL'] = array(2, ',', '.'); //  Euro
        $currencies['LUF'] = array(2, ',', '.'); //  Euro
        $currencies['NLG'] = array(2, ',', '.'); //  Euro
        $currencies['PTE'] = array(2, ',', '.'); //  Euro
        $currencies['GHC'] = array(2, '.', ','); //  Ghana, Cedi
        $currencies['GIP'] = array(2, '.', ','); //  Gibraltar Pound
        $currencies['GTQ'] = array(2, '.', ','); //  Guatemala, Quetzal
        $currencies['HNL'] = array(2, '.', ','); //  Honduras, Lempira
        $currencies['HKD'] = array(2, '.', ','); //  Hong Kong Dollar
        $currencies['HUF'] = array(0, '', '.'); //  Hungary, Forint
        $currencies['ISK'] = array(0, '', '.'); //  Iceland Krona
        $currencies['INR'] = array(2, '.', ','); //  Indian Rupee
        $currencies['IDR'] = array(2, ',', '.'); //  Indonesia, Rupiah
        $currencies['IRR'] = array(2, '.', ','); //  Iranian Rial
        $currencies['JMD'] = array(2, '.', ','); //  Jamaican Dollar
        $currencies['JPY'] = array(0, '', ','); //  Japan, Yen
        $currencies['JOD'] = array(3, '.', ','); //  Jordanian Dinar
        $currencies['KES'] = array(2, '.', ','); //  Kenyan Shilling
        $currencies['KWD'] = array(3, '.', ','); //  Kuwaiti Dinar
        $currencies['LVL'] = array(2, '.', ','); //  Latvian Lats
        $currencies['LBP'] = array(0, '', ' '); //  Lebanese Pound
        $currencies['LTL'] = array(2, ',', ' '); //  Lithuanian Litas
        $currencies['MKD'] = array(2, '.', ','); //  Macedonia, Denar
        $currencies['MYR'] = array(2, '.', ','); //  Malaysian Ringgit
        $currencies['MTL'] = array(2, '.', ','); //  Maltese Lira
        $currencies['MUR'] = array(0, '', ','); //  Mauritius Rupee
        $currencies['MXN'] = array(2, '.', ','); //  Mexican Peso
        $currencies['MZM'] = array(2, ',', '.'); //  Mozambique Metical
        $currencies['NPR'] = array(2, '.', ','); //  Nepalese Rupee
        $currencies['ANG'] = array(2, '.', ','); //  Netherlands Antillian Guilder
        $currencies['ILS'] = array(2, '.', ','); //  New Israeli Shekel
        $currencies['TRY'] = array(2, '.', ','); //  New Turkish Lira
        $currencies['NZD'] = array(2, '.', ','); //  New Zealand Dollar
        $currencies['NOK'] = array(2, ',', '.'); //  Norwegian Krone
        $currencies['PKR'] = array(2, '.', ','); //  Pakistan Rupee
        $currencies['PEN'] = array(2, '.', ','); //  Peru, Nuevo Sol
        $currencies['UYU'] = array(2, ',', '.'); //  Peso Uruguayo
        $currencies['PHP'] = array(2, '.', ','); //  Philippine Peso
        $currencies['PLN'] = array(2, '.', ' '); //  Poland, Zloty
        $currencies['GBP'] = array(2, '.', ','); //  Pound Sterling
        $currencies['OMR'] = array(3, '.', ','); //  Rial Omani
        $currencies['RON'] = array(2, ',', '.'); //  Romania, New Leu
        $currencies['ROL'] = array(2, ',', '.'); //  Romania, Old Leu
        $currencies['RUB'] = array(2, ',', '.'); //  Russian Ruble
        $currencies['SAR'] = array(2, '.', ','); //  Saudi Riyal
        $currencies['SGD'] = array(2, '.', ','); //  Singapore Dollar
        $currencies['SKK'] = array(2, ',', ' '); //  Slovak Koruna
        $currencies['SIT'] = array(2, ',', '.'); //  Slovenia, Tolar
        $currencies['ZAR'] = array(2, '.', ' '); //  South Africa, Rand
        $currencies['KRW'] = array(0, '', ','); //  South Korea, Won
        $currencies['SZL'] = array(2, '.', ', '); //  Swaziland, Lilangeni
        $currencies['SEK'] = array(2, ',', '.'); //  Swedish Krona
        $currencies['CHF'] = array(2, '.', '\''); //  Swiss Franc
        $currencies['TZS'] = array(2, '.', ','); //  Tanzanian Shilling
        $currencies['THB'] = array(2, '.', ','); //  Thailand, Baht
        $currencies['TOP'] = array(2, '.', ','); //  Tonga, Paanga
        $currencies['AED'] = array(2, '.', ','); //  UAE Dirham
        $currencies['UAH'] = array(2, ',', ' '); //  Ukraine, Hryvnia
        $currencies['USD'] = array(2, '.', ','); //  US Dollar
        $currencies['VUV'] = array(0, '', ','); //  Vanuatu, Vatu
        $currencies['VEF'] = array(2, ',', '.'); //  Venezuela Bolivares Fuertes
        $currencies['VEB'] = array(2, ',', '.'); //  Venezuela, Bolivar
        $currencies['VND'] = array(0, '', '.'); //  Viet Nam, Dong
        $currencies['ZWD'] = array(2, '.', ' '); //  Zimbabwe Dollar
        // custom function to generate: ##,##,###.##

        if ($curr == "INR" || $curr == "NPR") {
            return formatCrore($floatcurr);
        } else {
            return number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
        }
    }
}

if (!function_exists('formatCrore')) {
    function formatCrore($input)
    {

        $input = round((int) $input, 0);
        $dec = "";
        $pos = strpos($input, ".");
        if ($pos === false) {
            //no decimals
        } else {
            //decimals
            $dec = (string) substr(round(substr($input, $pos), 2), 1);
            $input = substr($input, 0, $pos);
        }
        $num = substr($input, -3); // get the last 3 digits
        $input = substr($input, 0, -3); // omit the last 3 digits already stored in $num
        // loop the process - further get digits 2 by 2
        while (strlen($input) > 0) {
            $num = substr($input, -2) . "," . $num;
            $input = substr($input, 0, -2);
        }
        return ($dec) ? $num . $dec : $num;
    }
}

if (!function_exists('passwordResetOtp')) {
    function passwordResetOtp()
    {
        try {
            $token = random_int(111111, 999999);
            $check = DB::table('password_reset_tokens')
                ->where('token', $token)
                ->first();
            if ($check) {
                $token = passwordResetOtp();
            }
            return $token;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
