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
        tr.row-border td {
            border-bottom-width:1px;
            border-top-width:1px;
            border-right-width:1px;
            border-left-width:1px;
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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">Employees in {!! $status !!} On {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!} <br/>
                        </span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


@if(!empty($data))

    @foreach($departments as $dept)

        <div>{!! $dept->department->name !!}</div>
        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>
            <tr class="row-line">
                <th width="22px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
                <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
 
                <th width="118px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
                <th width="55px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
                <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
               <th width="95px" style="text-align: left; font-size: 10px; font-weight: bold">Shift</th>
               <th width="60px" style="text-align: center; font-size: 10px; font-weight: bold">Entry_time</th>
            </tr>
            </thead>
            <tbody>

            @php($count = 1)

            @foreach($data as $row)
                @if($row->department_id == $dept->department_id)

                <tr>
                    <td width="22px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $count !!}</td>  
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>                  
                    <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="118px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!}</td>
                    <td width="55px" style="border-bottom-width:1px; font-size:8pt; ext-align: right">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
                    <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!}</td>
                   <td width="95px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!!$row->shift->short_name !!}--{!! \Carbon\Carbon::parse($row->shift_entry_time)->format('g:i A') !!}--{!! \Carbon\Carbon::parse($row->shift_exit_time)->format('g:i A') !!}</td>
                   @if(!empty($row->entry_time))
                   <td width="60px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!}</td>
                   @endif
                   <td width="60px" style="border-bottom-width:1px; font-size:8pt; text-align: center"></td>
                </tr>
                @php($count++)
                @endif

            @endforeach
            </tbody>

        </table>

        <div class="blank-space"></div>
    @endforeach


    <br pagebreak="true">

    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>

        <tr>
            <th colspan="3" style="text-align: left; font-size: 10px; font-weight: bold">Department Wise Summary  On {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!}</th>
        </tr>

        <tr class="row-line">
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="200px" style="text-align: left; font-size: 10px; font-weight: bold">Department Name</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">Total</th>
            <th width="180px" style="text-align: center; font-size: 10px; font-weight: bold">Name</th>
            <th width="80px" style="text-align: center; font-size: 10px; font-weight: bold">Signature </th>
        </tr>
        </thead>
        <tbody>

        @php($count = 1)

        @foreach($groups as $row)

            <tr class="row-border">
                <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $count !!}</td>
                <td width="200px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->department->name !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: center">{!! $row->emp_count !!}</td>
                <td width="180px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
                <td width="80px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
            </tr>
            @php($count++)

        @endforeach
        </tbody>
        <tfoot>
            <tr class="row-border">
                <td colspan="2" style="border-bottom-width:1px; font-size:10pt; text-align: center; font-weight: bold"> Total</td>
                <td style="border-bottom-width:1px; font-size:10pt; text-align: left; font-weight: bold">{!! $data->count() !!}</td>
            </tr>
            <tr class="row-border">
            <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
            <td width="200px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Without Roster</td>
                <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
                <td width="180px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
                <td width="80px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
            </tr>
            <tr class="row-border">
            <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
            <td width="200px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Security</td>
                <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
                <td width="180px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
                <td width="80px" style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
            </tr>
         
            <tr >
                <td colspan="2" style=" font-size:10pt; text-align: center; font-weight: bold"> Grand Total</td>
                <td style="font-size:10pt; text-align: left; font-weight: bold"></td>
            </tr>
        </tfoot>

    </table>

    
@endif

<div class="blank-space"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

