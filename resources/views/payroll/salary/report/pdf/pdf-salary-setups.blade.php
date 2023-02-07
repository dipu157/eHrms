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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">Salary Properties For {!! $department !!} Department</span></td>
                    </tr>

                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>



@if(!empty($salaries))
    @php($grandtotal = 0)

    @foreach($sections as $sec)



    {{--<div>{!! $emp !!}</div>--}}
    @if($salaries->contains('section_id',$sec->section_id))
        <div style="text-align: left; font-size: 10px; font-weight: bold">{!! $sec->section->name !!}</div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        <tr class="row-line">
            <th width="15px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="45px" style="text-align: left; font-size: 8px; font-weight: bold">ID</th>
            <th width="120px" style="text-align: left; font-size: 8px; font-weight: bold">Name</th>
            <th width="120px" style="text-align: left; font-size: 8px; font-weight: bold">Designation</th>
            <th width="50px" style="text-align: left; font-size: 8px; font-weight: bold">Basic</th>
            <th width="45px" style="text-align: left; font-size: 8px; font-weight: bold">House Rent</th>
            <th width="40px" style="text-align: left; font-size: 8px; font-weight: bold">Medical</th>
            <th width="40px" style="text-align: left; font-size: 8px; font-weight: bold">Entertainment</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Conveyance</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Other Allowance</th>
            <th width="55px" style="text-align: center; font-size: 8px; font-weight: bold">Gross Salary</th>
            <th width="55px" style="text-align: center; font-size: 8px; font-weight: bold">Cash Salary</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Income Tax</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Advance</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Mobile Others</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Bank</th>
            <th width="100px" style="text-align: center; font-size: 8px; font-weight: bold">Acc No</th>
            <th width="40px" style="text-align: center; font-size: 8px; font-weight: bold">Remarks</th>
        </tr>
        </thead>
        <tbody>

        @php($count = 1)
        @foreach($salaries as $row)
            @if($sec->section_id == $row->section_id)
            <tr >

                <td width="15px" style="font-size:8pt; text-align: left">{!! $count ++ !!}</td>
                <td width="45px" style="font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="120px" style="font-size:8pt; text-align: left">{!! $row->personal->full_name !!}</td>
                <td width="120px" style="font-size:8pt; text-align: left">{!! $row->designation->name !!}</td>
                <td width="50px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->basic,2) !!}</td>
                <td width="45px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->house_rent,2) !!}</td>

                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->medical,2) !!}</td>

                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->entertainment,2) !!}</td>
                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->conveyance,2) !!}</td>
                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->other_allowance,2) !!}</td>
                <td width="55px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->gross_salary,2) !!}</td>
                <td width="55px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->cash_salary,2) !!}</td>

                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->income_tax,2) !!}</td>

                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->advance,2) !!}</td>
                <td width="40px" style="font-size:8pt; text-align: right">{!! number_format($row->salary_properties->mobile_others,2) !!}</td>
                <td width="40px" style="font-size:8pt; text-align: right">{!! $row->salary_properties->bank_id == 1 ? 'AIBL' : 'DBBL' !!}</td>
                <td width="100px" style="font-size:8pt; text-align: right">{!! $row->salary_properties->account_no !!}</td>



                <td width="40px"></td>

            </tr>
            {{--@php($grand_total = $grand_total + $row['gr_total'] ?? 0)--}}

            @endif
        @endforeach
        </tbody>



    </table>
    @endif
    <div class="blank-space"></div>
    @endforeach
@endif



<div class="blank-space"></div>
<div class="blank-space"></div>

{{--<table class="table order-bank" width="90%" cellpadding="2">--}}

    {{--<thead>--}}
    {{--<tr>--}}
        {{--<th width="25%" style="text-align: left; font-size: 8px; font-weight: bold">Prepared By(Name & Sign)</th>--}}
        {{--<th width="25%" style="text-align: center; font-size: 8px; font-weight: bold">Department Head</th>--}}
        {{--<th width="25%" style="text-align: center; font-size: 8px; font-weight: bold">Checked By (HR & Admin)</th>--}}
        {{--<th width="25%" style="text-align: right; font-size: 8px; font-weight: bold">Approved Authority</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
{{--</table>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

