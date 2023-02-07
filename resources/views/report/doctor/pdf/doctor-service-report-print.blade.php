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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">Investigation Advised By {!! $doctor->doctor_name !!}
                                <br/> Form {!! \Carbon\Carbon::parse($fromDate)->format('d-M-Y') !!} To {!! \Carbon\Carbon::parse($toDate)->format('d-M-Y') !!}</span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>

@if(!empty($data))

    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        <tr class="row-line">
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            {{--<th width="150px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>--}}
            <th width="250px" style="text-align: left; font-size: 10px; font-weight: bold">Service Name</th>
            <th width="50px" style="text-align: right; font-size: 10px; font-weight: bold">IPD Count</th>
            <th width="50px" style="text-align: right; font-size: 10px; font-weight: bold">OPD Count</th>
            <th width="50px" style="text-align: right; font-size: 10px; font-weight: bold">Total</th>
            <th width="75px" style="text-align: right; font-size: 10px; font-weight: bold">OPD Amount</th>
        </tr>
        </thead>
        <tbody>

        @php($sub_count = 0)
        @php($sub_amt = 0)

        @foreach($data as $i=>$row)

            {{--@if($row->Sub_Dept_Code == $dpt->Sub_Dept_Code)--}}

                <tr>
                    <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $i+1 !!}</td>
                    {{--<td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->sub_name !!}</td>--}}
                    <td width="250px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->Service_Name !!}</td>
                    <td width="50px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->ipd_count,0) !!}</td>
                    <td width="50px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->opd_count,0) !!}</td>
                    <td width="50px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->opd_count + $row->ipd_count,0) !!}</td>
                    <td width="75px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->opd_amount,2) !!}</td>
                </tr>

                {{--@php($sub_count = $sub_count + $row->count_no)--}}
                @php($sub_amt = $sub_amt + $row->opd_amount)

            {{--@endif--}}
        @endforeach
        </tbody>

        <tfoot>

        <tr>
            <td colspan="5" style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">Grand Total (OPD)</td>
            <td style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">{!! number_format($sub_amt,2) !!}</td>

        </tr>
        </tfoot>
    </table>
    <div class="blank-space"></div>

@endif

<div class="blank-space"></div>

<div><span style="text-align: left; font-size: 10px; font-weight: bold">Department Wise Summary</span></div>

<table class="table order-bank" width="90%" cellpadding="2">

    <thead>
        <tr class="row-line" >
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="160px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th width="60px" style="text-align: right; font-size: 10px; font-weight: bold">IPD</th>
            <th width="60px" style="text-align: right; font-size: 10px; font-weight: bold">OPD</th>
            <th width="60px" style="text-align: right; font-size: 10px; font-weight: bold">Total</th>
            <th width="100px" style="text-align: right; font-size: 10px; font-weight: bold">OPD Amt</th>
        </tr>
    </thead>

    <tbody>

    @php($count = 1)
    @php($grand_total = 0)

    @foreach ($num as $sub => $services)

        <tr>
            @foreach ($services as $row)

                @php($sbname = $subdpt->where('sub_code',$sub)->first())

                <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $count !!}</td>
                <td width="160px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $sbname->sub_name !!}</td>
                <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! $row->ipdg !!}</td>
                <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! $row->opdg !!}</td>
                <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! $row->ipdg + $row->opdg !!}</td>
                <td width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->opda,2)  !!}</td>

                @php($count++)
                @php($grand_total = $grand_total + $row->opda)

            @endforeach
        </tr>
    @endforeach
    </tbody>

    <tfoot>
    <tr>
        <td colspan="5" style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">Grand Total (OPD)</td>
        <td style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">{!! number_format($grand_total,2) !!}</td>

    </tr>
    </tfoot>



</table>


{{--<div>{!! $num !!}</div>--}}

{{--@php($grand_count = 0)--}}
{{--@php($grand_amt = 0)--}}

{{--@foreach($sub_dpt as $dpt)--}}

    {{--@if($opd->contains('Sub_Dept_Code',$dpt->Sub_Dept_Code))--}}

        {{--<div>Department : {!! $dpt->sub_name !!}</div>--}}

        {{--<table class="table order-bank" width="90%" cellpadding="2">--}}

            {{--<thead>--}}
            {{--<tr class="row-line">--}}
                {{--<th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>--}}
                {{--<th width="150px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>--}}
                {{--<th width="300px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>--}}
                {{--<th width="50px" style="text-align: right; font-size: 10px; font-weight: bold">Count</th>--}}
                {{--<th width="100px" style="text-align: right; font-size: 10px; font-weight: bold">Amount</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}

            {{--@php($sub_count = 0)--}}
            {{--@php($sub_amt = 0)--}}

            {{--@foreach($opd as $i=>$row)--}}

                {{--@if($row->Sub_Dept_Code == $dpt->Sub_Dept_Code)--}}

                    {{--<tr>--}}
                        {{--<td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $i+1 !!}</td>--}}
                        {{--<td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->sub_name !!}</td>--}}
                        {{--<td width="300px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->Service_Name !!}</td>--}}
                        {{--<td width="50px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->count_no,0) !!}</td>--}}
                        {{--<td width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: right">{!! number_format($row->payable,2) !!}</td>--}}
                    {{--</tr>--}}

                    {{--@php($sub_count = $sub_count + $row->count_no)--}}
                    {{--@php($sub_amt = $sub_amt + $row->payable)--}}

                {{--@endif--}}
            {{--@endforeach--}}
            {{--</tbody>--}}

            {{--<tfoot>--}}

            {{--<tr>--}}
                {{--<td colspan="2" style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">Sub Total</td>--}}
                {{--<td style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">{!! number_format($sub_count,0) !!}</td>--}}
                {{--<td style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold;">{!! number_format($sub_amt,2) !!}</td>--}}

            {{--</tr>--}}
            {{--</tfoot>--}}
        {{--</table>--}}
        {{--<div class="blank-space"></div>--}}

        {{--@php($grand_count = $grand_count + $sub_count)--}}
        {{--@php($grand_amt = $grand_amt + $sub_amt)--}}

    {{--@endif--}}

{{--@endforeach--}}

<div class="blank-space"></div>
{{--<div style="justify-content: center; font-weight: bold">Grand Total : Investigation : {!! number_format($grand_count,0) !!} Amount {!! number_format($grand_amt,2) !!}</div>--}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

