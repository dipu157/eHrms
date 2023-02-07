<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <link href="{!! asset('assets/bootstrap-4.1.3/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    {{--<link rel="stylesheet" type="text/css" href="src/common/css/bootstrap.min.css" />--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script type="text/javascript" src="src/common/js/bootstrap.min.js"></script>--}}


    <style>
        table.table {
            width: 100%;
            margin: 0;
            background-color: #ffffff;
        }

        table.order-bank {
            width: 100%;
            margin: 0;
        }

        table.order-bank th {
            padding: 5px;
        }

        table.order-bank td {
            padding: 5px;
            background-color: #ffffff;
        }

        tr.row-line th {
            border-bottom-width: 1px;
            border-top-width: 1px;
            border-right-width: 1px;
            border-left-width: 1px;
        }

        tr.row-line td {
            border-bottom: none;
            border-bottom-width: 1px;
            font-size: 10pt;
        }

        th.first-cell {
            text-align: left;
            border: 1px solid red;
            color: blue;
        }

        div.order-field {
            width: 100%;
            backgroundr: #ffdab9;
            border-bottom: 1px dashed black;
            color: black;
        }

        div.blank-space {
            width: 100%;
            height: 50%;
            margin-bottom: 100px;
            line-height: 10%;
        }

        div.blank-hspace {
            width: 100%;
            height: 25%;
            margin-bottom: 50px;
            line-height: 10%;
        }
    </style>

</head>

<body>
    <div class="blank-space"></div>




    <table border="0" cellpadding="0">

        <tr>
            <td width="33%"><img src="{!! public_path('/assets/images/Logobrb.png') !!}" style="width:250px;height:50px;"></td>
            <td width="2%"></td>
            <td width="50%" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br /> West Panthapath, Dhaka-1215</span></td>

        </tr>
        <hr style="height: 2px">


    </table>

    <div class="blank-space"></div>

    <div>
        <table style="width:100%">
            <tr>
                <td style="width:5%"></td>
                <td style="width:90%">
                    <table style="width:100%" class="order-bank">
                        <thead>
                            <tr>
                                <td style="width:90%;"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">
                                        <h4>ANNUAL LEAVE CALCULATION - {!! $l_year !!} </h4> <br />
                                    </span></td>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="width:5%"></td>
            </tr>
        </table>
    </div>

    @if(!empty($final))
    @foreach($final as $row)

    @php

    $total_leaveAvailed = $total_wHolidays + $total_gHolidays + $row->absent + $emp_yearly_leave[0]->leave_enjoyed + $emp_yearly_leave[1]->leave_enjoyed + $emp_yearly_leave[3]->leave_enjoyed + $emp_yearly_leave[4]->leave_enjoyed + $emp_yearly_leave[5]->leave_enjoyed + $emp_yearly_leave[6]->leave_enjoyed + $emp_yearly_leave[7]->leave_enjoyed + $emp_yearly_leave[8]->leave_enjoyed + $emp_yearly_leave[9]->leave_enjoyed ;

    $present = $total_wDays - $total_leaveAvailed;

    $leave_earned = (int)($present/18);

    $next_year_leave = ($emp_yearly_leave[3]->leave_balance) + $leave_earned;

    if($next_year_leave > 60){

    $next_year_leave_deduct = $next_year_leave - 60;

    $next_year_leave_final = 60;
}


    @endphp
    <table class="table order-bank" width="100%" style="font-size: 9px;">

        <tr>
            <td width="10%"></td>
            <td width="50%">PF No </td>
            <td>: {!! $row->professional->pf_no !!}</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%" >Employee ID</td>
            <td>: {!! $row->employee_id !!}</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Name</td>
            <td><b>: {!! $row->professional->personal->full_name !!}</b></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Designation</td>
            <td><b>: {!! $row->designation !!}</b></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Date of Joining</td>
            <td><b>: {!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-m-Y') !!}</b></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Leave Calculation Period</td>
		 @if($w_months>= 12 )
            <td>: {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</td>
                        @else
                        <td>:{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-m-Y') !!} To {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</td>
                        @endif	
	</tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Total Working Days</td>
            <td>: {!! $total_wDays !!} days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Total Present Days</td>
            <td>: {!! $present !!} days</td>
        </tr> <br />

        <tr>
            <td width="10%"></td>
            <td style="float: right;">
                <h4>PARTICULARS OF LEAVES: </h4>
            </td>
        </tr> <br />

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Weekly Holiday</td>
            <td>: {!! $total_wHolidays !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Festival Holiday</td>
            <td>: {!! $total_gHolidays !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Earned Leave</td>
            <td>: {!! $emp_yearly_leave[3]->leave_enjoyed !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Casual Leave</td>
            <td>: {!! $emp_yearly_leave[0]->leave_enjoyed !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Sick Leave</td>
            <td>: {!! $emp_yearly_leave[1]->leave_enjoyed !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Leave Without Pay</td>
            <td>: {!! $emp_yearly_leave[8]->leave_enjoyed + $row->absent + $emp_yearly_leave[9]->leave_enjoyed !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Maternity Leave</td>
            <td>: {!! $emp_yearly_leave[4]->leave_enjoyed !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Availed Others Leave</td>
            <td>: {!! $emp_yearly_leave[5]->leave_enjoyed + $emp_yearly_leave[6]->leave_enjoyed +$emp_yearly_leave[7]->leave_enjoyed !!}   Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%">Total Leave Availed</td>
            <td>: {!! $total_leaveAvailed !!} Days</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%"><b>Earned Leave Accumulated up to December 31, {!! $l_year !!}</b></td>
            <td><b>: {!! ($emp_yearly_leave[3]->leave_balance) !!} Days </b></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%"><b>Leave Earned in {!! $l_year !!}</b></td>
            <td><b>: {!! $leave_earned !!} Days </b></td>
        </tr>


        @if(isset($next_year_leave_deduct))

        <tr>
            <td width="10%"></td>
            <td width="50%"><b>Total Earned Leave Accumulated to {!! $l_year + 1 !!}</b></td>
            <td><b>: {!! $next_year_leave !!} Days </b></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%"><b>Total Earned Leave Deduct for over 60 days</b></td>
            <td>: - {!! $next_year_leave_deduct !!} Days </td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="50%"><b>Total Earned Leave Accumulated & carried forward to {!! $l_year + 1 !!}</b></td>
            <td><b>: {!! $next_year_leave_final !!} Days </b></td>
        </tr>

        @else

        <tr>
            <td width="10%"></td>
            <td width="50%"><b>Total Earned Leave Accumulated & carried forward to {!! $l_year + 1 !!}</b></td>
            <td><b>: {!! $next_year_leave !!} Days </b></td>
        </tr>

        @endif

        @endforeach

    </table>
    @endif

    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>

<table class="table order-bank" width="90%" cellpadding="2">

    <thead>
    <tr>
        <th width="10%" style="text-align: left; font-size: 10px; font-weight: bold"></th>
        <th width="35%" style="text-align: left; font-size: 9px; font-weight: bold">Prepared By(Name & Sign)</th>
        <th width="10%" style="text-align: left; font-size: 12px; font-weight: bold"></th>
        <th width="35%" style="text-align: right; font-size: 9px; font-weight: bold">Approved Authority</th>
    </tr>
    </thead>
</table>





    <div class="blank-space"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>

</html>