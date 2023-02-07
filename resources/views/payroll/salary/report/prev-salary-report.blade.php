<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--    <link href="{!! asset('assets/bootstrap-4.1.3/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    {{--<link rel="stylesheet" type="text/css" href="src/common/css/bootstrap.min.css" />--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script type="text/javascript" src="src/common/js/bootstrap.min.js"></script>--}}


    <style>
        table.table {
            width:100%;
            margin:0;
            background-color: #ffffff;
        }

        table.order-bank {
            width:100%;
            margin:0;
        }
        table.order-bank th{
            padding:5px;
        }
        table.order-bank td {
            padding:5px;
            background-color: #ffffff;
        }
        tr.row-line th {
            border-bottom-width:1px;
            border-top-width:1px;
            border-right-width:1px;
            border-left-width:1px;
        }
        tr.row-line td {
            border-bottom:none;
            border-bottom-width:1px;
            font-size:10pt;
        }
        tr.row-border td {
            border-bottom-width:1px;
            border-top-width:1px;
            border-right-width:1px;
            border-left-width:1px;
        }
        th.first-cell {
            text-align:left;
            border:1px solid red;
            color:blue;
        }
        div.order-field {
            width:100%;
            backgroundr: #ffdab9;
            border-bottom:1px dashed black;
            color:black;
        }
        div.blank-space {
            width:100%;
            height: 50%;
            margin-bottom: 100px;
            line-height: 10%;
        }

        div.blank-hspace {
            width:100%;
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
        <td width="33%"><img src="{!! public_path('/assets/images/Logobrb.png') !!}" style="width:250px;height:60px;"></td>
        <td width="2%"></td>
        <td width="60%" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br/> West Panthapath, Dhaka-1215</span></td>

    </tr>
    {{--<tr>--}}
    {{--<td colspan="3"><span style="line-height: 60%; text-align:center; font-family:times;font-weight:bold;font-size:20pt;color:black;">77/A, East Rajabazar,West Panthapath, Dhaka-1215</span></td>--}}
    {{--</tr>--}}
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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">Salary For The Month : {!! $period->month_name !!}, {!! $period->calender_year !!}</span></td>
                    </tr>

                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">Salary For The Employee : {!! $period->month_name !!}, {!! $period->calender_year !!}</span></td>
                    </tr>

                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>

    @if(!empty($salaries))
    @php($count=1)

    @foreach($departments as $dept)
        <div style="text-align: left; font-size: 10px; font-weight: bold">{!! $dept->department->name !!}</div>

                    <table class="table order-bank" width="90%" cellpadding="2">

                        <thead>

                        <tr class="row-line">
                            <th rowspan="2" width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                            <th rowspan="2" width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF No</th>
                            <th rowspan="2" width="45px" style="text-align: left; font-size: 8px; font-weight: bold">ID</th>
                            <th rowspan="2" width="100px" style="text-align: left; font-size: 8px; font-weight: bold">Name</th>
                            <th rowspan="2" width="80px" style="text-align: left; font-size: 8px; font-weight: bold">Designation</th>
                            <th rowspan="2" width="45px" style="text-align: left; font-size: 8px; font-weight: bold">Joining Date</th>
                            <th colspan="7" scope="colgroup" width="275px" style="text-align: center; font-size: 10px; font-weight: bold">Structured Salary With Schale</th>
                            <th rowspan="2" width="25px" style="text-align: center; font-size: 8px; font-weight: bold">Days to <br/> be paid</th>
                            <th rowspan="2" width="55px" style="text-align: center; font-size: 8px; font-weight: bold">Earned <br/> Salary</th>
                            {{--<th rowspan="2" width="15px" style="text-align: center; font-size: 8px; font-weight: bold">No</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Increment <br/>Amt</th>--}}
                            <th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Increment <br/> Arear</th>



                            <th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Other <br/> Arear</th>

                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Overtime <br/> Hour</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Overtime <br/> Amount</th>--}}
                            <th colspan="2" scope="colgroup" width="60px" style="text-align: center; font-size: 8px; font-weight: bold">Overtime</th>

                            <th rowspan="2" width="55px" style="text-align: center; font-size: 8px; font-weight: bold">Payable <br/> Salary</th>

                            <th colspan="5" scope="colgroup" width="180px" style="text-align: center; font-size: 8px; font-weight: bold">Deduction</th>

                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">TDS</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Advance</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Mobile <br/> Others</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Food</th>--}}
                            {{--<th rowspan="2" width="20px" style="text-align: center; font-size: 8px; font-weight: bold">R Stamp</th>--}}



                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Income Tax</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Advance</th>--}}
                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Mobile Others</th>--}}
                            <th rowspan="2" width="50px" style="text-align: center; font-size: 8px; font-weight: bold">Net Salary</th>
                            {{--<th rowspan="2" width="100px" style="text-align: center; font-size: 8px; font-weight: bold">Acc No</th>--}}
                            <th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Remarks</th>
                        </tr>

                        <tr class="row-line">

                            <th width="45px" style="text-align: left; font-size: 8px; font-weight: bold">Basic</th>
                            <th width="45px" style="text-align: left; font-size: 8px; font-weight: bold">House Rent</th>
                            <th width="30px" style="text-align: left; font-size: 8px; font-weight: bold">Medical</th>
                            <th width="30px" style="text-align: left; font-size: 8px; font-weight: bold">Entertainment</th>
                            <th width="30px" style="text-align: center; font-size: 8px; font-weight: bold">Conveyance</th>
                            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Other Allowance</th>
                            <th width="55px" style="text-align: center; font-size: 8px; font-weight: bold">Gross Salary</th>

                            <th width="25px" style="text-align: center; font-size: 8px; font-weight: bold">Hour</th>
                            <th width="35px" style="text-align: center; font-size: 8px; font-weight: bold">Amount</th>

                            {{--<th rowspan="2" width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Overtime <br/> Amount</th>--}}

                            <th width="40px" style="text-align: left; font-size: 8px; font-weight: bold">TDS</th>
                            <th width="40px" style="text-align: left; font-size: 8px; font-weight: bold">Adance</th>
                            <th width="40px" style="text-align: left; font-size: 8px; font-weight: bold">Mobile <br/>Others</th>
                            <th width="40px" style="text-align: left; font-size: 8px; font-weight: bold">Food <br/>Charge</th>
                            <th width="20px" style="text-align: center; font-size: 8px; font-weight: bold">Stamp</th>


                        </tr>
                        </thead>


                        <tbody>
                            @foreach($salaries as $row)
                                @if($dept->department_id == $row->department_id)

                                <tr class="row-border">

                                            <td width="20px" style="font-size:8pt; text-align: left">{!! $count ++ !!}</td>
                                            <td width="30px" style="font-size:8pt; text-align: left">{!! $row->pf_no !!}</td>
                                            <td width="45px" style="font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                                            <td width="100px" style="font-size:8pt; text-align: left">{!! $row->personal->full_name !!}</td>
                                            <td width="80px" style="font-size:8pt; text-align: left">{!! $row->designation->name !!}</td>

                                            <td width="45px" style="font-size:8pt; text-align: left">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-m-Y') !!}</td>

                                            <td width="45px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->basic ?? 0,0) !!}</td>
                                            <td width="45px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->house_rent ?? 0,0) !!}</td>

                                            <td width="30px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->medical ?? 0,0) !!}</td>

                                            <td width="30px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->entertainment ?? 0,0) !!}</td>
                                            <td width="30px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->conveyance ?? 0,0) !!}</td>
                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->other_allowance ?? 0,0) !!}</td>
                                            <td width="55px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->gross_salary ?? 0,0) !!}</td>

                                            <td width="25px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->paid_days ?? 0,0) !!}</td>
                                            <td width="55px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->earned_salary ?? 0,0) !!}</td>

                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->increment_amt ?? 0,0) !!}</td>
                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->arear_amount ?? 0,0) !!}</td>

                                            <td width="25px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->overtime_hour ?? 0,0) !!}</td>
                                            <td width="35px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->overtime_amount ?? 0,0) !!}</td>

                                            <td width="55px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->payable_salary ?? 0,0) !!}</td>


                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->income_tax ?? 0,0) !!}</td>

                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->advance ?? 0,0) !!}</td>
                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->mobile_others ?? 0,0) !!}</td>

                                            <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->food_charge ?? 0,0) !!}</td>
                                            <td width="20px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->stamp_fee ?? 0,0) !!}</td>

                                            <td width="50px" style="font-size:8pt; text-align: right">{!! number_format($row->salary->net_salary ?? 0,0) !!}</td>

                                            <td width="40px"></td>

                                </tr>
                                @endif
                            @endforeach
                        </tbody>

                    </table>
    @endforeach
    @endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

