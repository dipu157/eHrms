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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">

                        {!! $status == 1 ? 'Late Attendance Report' : ($status == 2 ? 'Absent Report' : ($status == 3 ? 'Employee In Leave Report' : null)) !!} </span></td>
                    </tr>
                    <tr>

                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:11pt;color:#000000; ">

                        Department Name : {!! $data[0]->department->name !!}</span></td>
                    </tr>
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:11pt;color:#000000; ">Report Date From {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To  {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}<br/>
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

@foreach($employees as $emp)

        <table style="width:100%" class="order-bank">
            <thead>
            <tr>
                <td><span style="text-align:left; border: #000000; font-family:times;font-weight:bold;font-size:10pt;color:#000000; ">{!! $emp->employee_id !!} : {!! $emp->professional->personal->full_name !!} <br/>{!! $emp->professional->designation->name !!}</span></td>
            </tr>

            </thead>
        </table>



        <table class="table order-bank" width="100%" cellpadding="2">

            <thead>

                <tr class="row-line">
                    <th  width="25px" style="text-align: center; font-size: 10px; font-weight: bold">SL</th>
                    <th  width="55px" style="text-align: center; font-size: 10px; font-weight: bold">Date</th>
                    @if($status == 1)
                    <th  width="200px" style="text-align: center; font-size: 10px; font-weight: bold">Schedule</th>
                    <th width="150px" style="text-align: center; font-size: 10px; font-weight: bold">Entry Time</th>
                    <th  width="55px" style="text-align: center; font-size: 10px; font-weight: bold">Late</th>
                    @endif
                    @if($status == 3)
                        <th width="200px" style="text-align: center; font-size: 10px; font-weight: bold">Leave</th>
                    @endif
                </tr>

            </thead>
            <tbody>

            @php($count=1)

            @foreach($data as $row)




                    <tr>
                        <td  width="25px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $count !!}</td>
                        <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->attend_date)->format('d-M-Y') !!}</td>
                        @if($status == 1)
                        <td  width="200px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->shift->short_name !!} : {!! \Carbon\Carbon::parse($row->shift_entry_time)->format('g:i A') !!} to {!! \Carbon\Carbon::parse($row->shift_exit_time)->format('g:i A') !!}</td>
                        <td  width="150px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->attend_date)->format('d-M-Y') !!} : {!! \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!}</td>
                        <td  width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->late_minute !!}</td>
                        @endif

                        @if($status == 3)
                            <td  width="200px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->leave->name !!}</td>
                        @endif

                        @php($count++)
                    </tr>
                
            @endforeach
            </tbody>
        </table>
        <div class="blank-space"></div>
   
        @endforeach
@endif




<div class="blank-space"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>
