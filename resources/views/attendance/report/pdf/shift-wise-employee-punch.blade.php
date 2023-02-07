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
            padding:0px;
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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">

                       Department Name </span>: {{ $department[0]->name }}</td>

                    </tr>

                    <tr>
                      <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:11pt;color:#000000; ">Shifting Schedule : {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!} <br/>
                        </span></td>
                    </tr>
                        
                    </thead>
                </table>

                </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


    @if($data->contains('employee_id',$department[0]->headed_by))

        <table class="table order-bank" cellpadding="2">

        <thead>

        <tr class="row-line">
            <th width="80px" style="text-align: left; font-size: 8px;" rowspan="2">Overall Supervision          General Shift  (9:00am--6:00pm)</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF NO</th>
            <th width="90px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="90px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">In Time</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Out Time</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">Late</th>
            <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">Status</th>
          
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)

       
        @foreach($data as $row)
             @if($row->employee_id == $department[0]->headed_by)

                <tr>
                    <td width="80px"></td>
                    <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                    <td width="90px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                    <td width="90px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                    <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! is_null($row->entry_time) ? '' : \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!}</td>
                    <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! is_null($row->exit_time) ? '' : \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!}</td>
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->late_minute !!}</td>
                    
                    @if($row->leave_flag && $row->offday_flag == 1 || $row->leave_flag && $row->holiday_flag == 1)
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! ($row->offday_flag == 1  ? '' : ($row->holiday_flag == 1 ? '': 'Absent')) !!}{!! $row->leave->short_code !!}</td>

                        @else
                            <td width="50px" style="border-bottom-width:1px; border-right-width:1px; font-size:8pt; text-align: center">{!! $row->attend_status == 'P' ? 'Present' : ($row->offday_flag == 1 ? 'Off Day' : ($row->holiday_flag == 1 ? 'Public Holiday' : ($row->leave_id  == 1  ? 'CL' : ($row->leave_id  == 2  ? 'SL' : ($row->leave_id  == 3  ? 'AL' :($row->leave_id  == 4  ? 'EL' :($row->leave_id  == 5  ? 'ML' :($row->leave_id  == 8  ? 'SPL' :($row->leave_id  == 9  ? 'LWP' :'Absent' ))))))))) !!}</td>
                        @endif

                </tr>
            @endif
        @endforeach
        {{--@endforeach--}}
        </tbody>
        </table>
    @endif
                  
            
    <div class="blank-space"></div>
                            
@foreach($shifts as $i=>$spt)

      
@if($data->contains('shift_id',$spt->shift_id))

    {{--<div>Department : {!! $dept->name !!} :  {!! $data->count() !!}</div>--}}
   
    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        <tr>
             <th style="text-align: center; font-size: 10px; font-weight: bold"> {!! $spt->shift->name !!}-({!! \Carbon\Carbon::parse($spt->shift->from_time)->format('g:i A') !!}--{!! \Carbon\Carbon::parse($spt->shift->to_time)->format('g:i A') !!}) </th>

        </tr>
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th> 
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF No</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="100px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="100px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">In Time</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Out Time</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">Late</th>
            <th width="50px" style="text-align: center; font-size: 10px; font-weight: bold">Status</th>
            <th width="70px" style="text-align: center; font-size: 10px; font-weight: bold">Location</th>
            
          
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)

       
        @foreach($data as $row)
            @if($spt->shift_id == $row->shift_id)

                <tr>
                    <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>                   
                    <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="100px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                    <td width="100px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                    <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! is_null($row->entry_time) ? '' : \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!}</td>
                    <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! is_null($row->exit_time) ? '' : \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!}</td>
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->late_minute !!}</td>
                    
                    @if($row->leave_flag && $row->offday_flag == 1 || $row->leave_flag && $row->holiday_flag == 1)
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! ($row->offday_flag == 1  ? '' : ($row->holiday_flag == 1 ? '': 'Absent')) !!}{!! $row->leave->short_code !!}</td>

                        @else
                        <td width="50px" style="border-bottom-width:1px; border-right-width:1px; font-size:8pt; text-align: center">{!! $row->attend_status == 'P' ? 'Present' : ($row->offday_flag == 1 ? 'Off Day' : ($row->holiday_flag == 1 ? 'Public Holiday' : ($row->leave_id  == 1  ? 'CL' : ($row->leave_id  == 2  ? 'SL' : ($row->leave_id  == 3  ? 'AL' :($row->leave_id  == 4  ? 'EL' :($row->leave_id  == 5  ? 'ML' :($row->leave_id  == 8  ? 'SPL' :($row->leave_id  == 9  ? 'LWP' :'Absent' ))))))))) !!}</td>
                        @endif

                        <td width="70px" style="border-bottom-width:1px; border-right-width:1px;  font-size:8pt; text-align: left">{!! $row->location !!}</td>
                </tr>
                @php($sl++)
            @endif
        @endforeach
        {{--@endforeach--}}
        </tbody>
    </table>

    <div class="blank-space"></div>
@endif
    
@endforeach


<div class="blank-space"></div>
Total Manpower </span>: {!! $employees->count() !!}</td>
<div class="blank-space"></div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>