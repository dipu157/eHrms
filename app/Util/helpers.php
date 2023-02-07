<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/15/18
 * Time: 4:37 PM
 */

if (!function_exists('int_random')) {

    /**
     * generate secure random numbers
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function int_random($min = 10000000, $max = 99999999, $bytes = 4)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $strong = true;
            $n = 0;

            do {
                $n = hexdec(
                    bin2hex(openssl_random_pseudo_bytes($bytes, $strong))
                );
            } while ($n < $min || $n > $max);

            return $n;
        } else {
            return mt_rand($min, $max);
        }
    }
}


if (!function_exists('get_company_name')) {

    /**
     * get company name
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function get_company_name($id = 1)
    {
        $compname = \App\Models\Company\Company::find($id) ->value('name');

        return $compname;
    }

}

if (!function_exists('get_company_address')) {

    /**
     * get company address
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function get_company_address($id = 1)
    {
        $address = \App\Models\Company\Company::find($id) ->value('address');

        return $address;
    }
}


if (!function_exists('check_privilege')) {

    /**
     * check users privilege
     *
     * @param int $email
     * @param var $privilege id
     *
     * @param var $use case id
     *
     * @return boolean
     */
    function check_privilege($uid, $pid) //$pid= 1=view, 2=add, 3=edit, 4=delete
    {
        $id = \Illuminate\Support\Facades\Auth::user()->id;
        switch($pid)
        {
            case 1:

                $value = \App\Models\Common\Privilege::query()->where('user_id',$id)
                    ->where('menu_id',$uid)->where('view',true)->first();

                break;

            case 2:
                $value = \App\Models\Common\Privilege::query()->where('user_id',$id)
                    ->where('menu_id',$uid)->where('add',true)->first();
                break;

            case 3:
                $value = \App\Models\Common\Privilege::query()->where('user_id',$id)
                    ->where('menu_id',$uid)->where('edit',true)->first();
                break;

            case 4:
                $value = \App\Models\Common\Privilege::query()->where('user_id',$id)
                    ->where('menu_id',$uid)->where('delete',true)->first();
                break;

            default:
                $value = '';
        }

        if(!empty($value))
        {
            return true;
        }else{
            return false;
        }
    }
}


if (!function_exists('addMonths')) {

    /**
     * get company address
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function addMonths($date, $months)
    {
        {
            $date = new \DateTime($date);
            $date->modify("+" . $months . " months");

            $date->modify("-1 day");

            return $date->format('Y-m-d');
        }
    }
}



if (!function_exists('get_resource_id')) {

    /**
     * get company address
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function get_resource_id($email)
    {

        $data = \App\Models\Hresource::query()->where('email',$email)->first();
        return $data->id;
    }

}

function convertToCamelCase(string $value, string $encoding = null) {
    if ($encoding == null){
        $encoding = mb_internal_encoding();
    }
    $stripChars = "()[]{}=?!.:,-_+\"#~/";
    $len = strlen( $stripChars );
    for($i = 0; $len > $i; $i ++) {
        $value = str_replace( $stripChars [$i], " ", $value );
    }
    $value = mb_convert_case( $value, MB_CASE_TITLE, $encoding );
    $value = preg_replace( "/\s+/", " ", $value );
    return $value;
}


if (!function_exists('get_doctor_external_id')) {

    /**
     * get company address
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function get_doctor_external_id($id)
    {
        $data = \App\Models\Hresource::query()->where('id',$id)->first();
        return $data->external_id;
    }

}


if (!function_exists('dateDifference')) {

    /**
     * get company address
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

}


if (!function_exists('getPreviousDay')) {

    /**
     * get company address
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function getPreviousDay($date_1)
    {

        $date_2 = date('Y-m-d', strtotime('-1 day', strtotime($date_1)));

        return $date_2;
    }

}


if (!function_exists('getNextDay')) {

    /**
     * get Next day from given date
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function getNextDay($date_1)
    {

        $date_2 = date('Y-m-d', strtotime('+1 day', strtotime($date_1)));

        return $date_2;
    }

}



if (!function_exists('createDateRange')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);

        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }

}

if (!function_exists('checkDateExistBetweenTwoDate')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function checkDateExistBetweenTwoDate($startDate, $endDate, $checkDate, $format = "Y-m-d")
    {
        $checkDate = date('Y-m-d', strtotime($checkDate));
//echo $paymentDate; // echos today!
        $contractDateBegin = date('Y-m-d', strtotime($startDate));
        $contractDateEnd = date('Y-m-d', strtotime($endDate));

        if (($checkDate >= $contractDateBegin) && ($checkDate <= $contractDateEnd)){
            $value = true;
        }else{
            $value = false;
        }

        return $value;
    }

}



if (!function_exists('get_user_role_id')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function get_user_role_id($id)
    {
        $role = \App\User::query()->where('id',$id)->first();

        return $role->role_id;
    }

}


if (!function_exists('get_shift_data')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function get_shift_data($id)
    {
        $shift = \App\Models\Roster\Shift::query()->find($id);

        $short_name = isset($shift->short_name) ? $shift->short_name : '';
        $from = isset($shift->from_time) ? \Carbon\Carbon::parse($shift->from_time)->format('H:i') : '';
        $totime = isset($shift->to_time) ? \Carbon\Carbon::parse($shift->to_time)->format('H:i') : '';

        $template = ''. $short_name .' <br/> '. $from .' <br/> '. $totime .'';

        return $template ;
    }

}



if (!function_exists('get_shift_name_one_line')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function get_shift_name_one_line($id)
    {
        $shift = \App\Models\Roster\Shift::query()->find($id);

        $short_name = isset($shift->short_name) ? $shift->short_name : '';
        $from = isset($shift->from_time) ? \Carbon\Carbon::parse($shift->from_time)->format('g A') : '';
        $totime = isset($shift->to_time) ? \Carbon\Carbon::parse($shift->to_time)->format('g A') : '';

        $template = ''. $short_name .' '. $from .' : '. $totime .'';

        return $template ;
    }

}


if (!function_exists('get_shift_short_name')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function get_shift_short_name($id, $day_no,$year,$month)
    {

        $dt = $year.'-'.$month.'-'.$day_no;

        $gn =  date('D', strtotime($dt)) == 'Fri' ? 1 : 0;


        $shift = \App\Models\Roster\Shift::query()->find($id);

        $short_name = isset($shift->short_name) ? $shift->short_name : ($gn == 1 ? 'OF' : 'G') ;
        return $short_name ;
    }

}


if (!function_exists('check_friday')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function check_friday($day_no,$year,$month)
    {
        $dt = $year.'-'.$month.'-'.$day_no;

        return date('D', strtotime($dt)) == 'Fri' ? 1 : 0;
    }

}



if (!function_exists('get_working_hour_from_roster')) {

    /*
     * Returns Total Working Hour as per roster of a month
     * Param ID is the row d of the specific roster row
     */
    function get_working_hour_from_roster($id)
    {
        $hour = 0;
        $shift = \App\Models\Roster\Shift::query()->get();

        if(!is_null($id))
        {
            $roster = \App\Models\Roster\Roster::query()->where('id',$id)->first();
            $year = $roster->r_year;
            $month = $roster->month_id;

            $d = cal_days_in_month(CAL_GREGORIAN,$month,$year);

            for($i=1; $i<=$d; $i++)
            {

                $dt = $year.'-'.$month.'-'.$i;
                $gn =  date('D', strtotime($dt)) == 'Fri' ? 1 : 0;


                $dgt = str_pad($i, 2, '0', STR_PAD_LEFT);
                $fld = 'day_'.$dgt;

                $h1 = $shift->where('id',$roster->{$fld})->first();


                $hour = $hour + (is_null($h1) ? ($gn == 1 ? 0 : 9) : $h1->duty_hour) ;
            }
        }

        return $hour;
    }
}


if (!function_exists('get_month_from_number')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function get_month_from_number($id)
    {

        $monthNum  = $id;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
        return $monthName ;
    }

}



if (!function_exists('get_roster_day_from_number')) {

    /*
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range
     * @param string $endDate the end of the date range
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    function get_roster_day_from_number($day_no,$year,$month)
    {
//        $dept_id = \Illuminate\Support\Facades\Session::get('session_user_dept_id');
//
//        $department = \App\Models\Common\Department::query()->where('company_id',\Illuminate\Support\Facades\Auth::user()->company_id)
//        ->where('id',$dept_id)->first();

//        $input = $department->roster_year.'-'.$department->roster_month_id.'-'.$day_no;

        $input = $year.'-'.$month.'-'.$day_no;


        $day = date('D', strtotime($input));
        return $day ;
    }

}


if (!function_exists('time_elapsed_string')) {


    function time_elapsed_string($datetime, $full = false)
    {
        date_default_timezone_set('Asia/Dhaka');
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
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

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}

if (!function_exists('convert_number_to_words')) {

    function convert_number_to_words($number) {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'Zero',
            1                   => 'One',
            2                   => 'Two',
            3                   => 'Three',
            4                   => 'Four',
            5                   => 'Five',
            6                   => 'Six',
            7                   => 'Seven',
            8                   => 'Eight',
            9                   => 'Nine',
            10                  => 'Ten',
            11                  => 'Eleven',
            12                  => 'Twelve',
            13                  => 'Thirteen',
            14                  => 'Fourteen',
            15                  => 'Fifteen',
            16                  => 'Sixteen',
            17                  => 'Seventeen',
            18                  => 'Eighteen',
            19                  => 'Nineteen',
            20                  => 'Twenty',
            30                  => 'Thirty',
            40                  => 'Fourty',
            50                  => 'Fifty',
            60                  => 'Sixty',
            70                  => 'Seventy',
            80                  => 'Eighty',
            90                  => 'Ninety',
            100                 => 'Hundred',
            1000                => 'Thousand',
            1000000             => 'Million',
            1000000000          => 'Billion',
            1000000000000       => 'Trillion',
            1000000000000000    => 'Quadrillion',
            1000000000000000000 => 'Quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
}

 function dayCount($from, $to, $day = 5) {
           
            $from = new DateTime($from);
            $to   = new DateTime($to);
            $wF = $from->format('w');
            $wT = $to->format('w');
            if ($wF < $wT)       
                $isExtraDay = $day >= $wF && $day <= $wT;

            else if ($wF == $wT) 
                $isExtraDay = $wF == $day;
            else                 
                $isExtraDay = $day >= $wF || $day <= $wT;

            return floor($from->diff($to)->days / 7) + $isExtraDay;
}

function nb_mois($date1, $date2)
{

    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    return $diff;

}








