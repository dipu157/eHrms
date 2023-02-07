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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:13pt;color:#000000; ">Overtime Approve or Reject Report <br> 
                            Reporting Time : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}<br/>
                            Department  : {!! $data[0]->professional->department->name !!}</span></td>
                    </tr>
                    @if($employee_id->count()>0)
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">{!! $data[0]->employee_id !!} :  {!! $data[0]->professional->personal->full_name !!}<br/>
 </span></td>
                    </tr>
                    @endif
                   
                    </thead>
                </table>
         
           
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


@foreach($dates as $i=>$date)

    @if($data->contains('ot_date',$date))

        <div>Date: {!! \Carbon\Carbon::parse($date)->format('d-M-Y') !!}</div>

        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>
            <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="45px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
                <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
                <th width="45px" style="text-align: left; font-size: 10px; font-weight: bold">Type</th>
                <th width="80px" style="text-align: center; font-size: 10px; font-weight: bold">Entry&Exit <br/>Time</th>
                <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">Assign <br/>Hour</th>
                <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">Punch<br/>Hour</th>
                <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">Final<br/>Hour</th>


                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Reject Reason</th>
                <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Status</th>
            </tr>
            </thead>
            <tbody>

            @php($count = 1)

                @foreach($data as $row)
                    @if($date == $row->ot_date)
                        <tr>
                        <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $count !!}</td>
                            <td width="45px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                            <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!}</td>
                            <td width="45px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->ot_type == 'S' ? 'Scheduled' : ($row->ot_type == 'O' ? 'Off Day' : 'Holiday') !!}</td>
                            <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!} | {!! \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!} </td>
                            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->ot_hour !!}</td>
                            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->overtime_from_punch !!}</td>
                            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->actual_overtime_hour !!}</td>

                            <td width="60px" style="border-bottom-width:1px; font-size:8pt; color: #7d0000;text-align: center">{!! $row->reject_Reason !!}</td>
                            <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{{$row->status==1 ? "Approve" : "Reject"}}</td>
                        </tr>

                        @php($count++)
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="blank-space"></div>

    @endif


@endforeach
    
    <table border="0" cellpadding="0">

        <div class="blank-space"></div>

    <tr>
        <td><span style="font-family:times;font-weight:bold;color:black;">Total Approve Hour : {!! number_format($data->sum('actual_overtime_hour')) !!} Hours </span></td>
        {{-- <td width="2%"></td>
        <td width="60%" style="text-align: right"><span style="font-family:times;font-weight:bold;color:black;">Total Reject Hour : Hours </span></td> --}}

    </tr>

</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

