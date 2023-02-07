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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">{!! $data[0]->employee_id !!} :  {!! $data[0]->professional->personal->full_name !!}<br/>
                        Department Name : {!! $data[0]->department->name !!}<br/></span></td>
                    </tr>
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">Attendance From {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To  {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}<br/>
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

        <table id="myTable" class="table order-bank" width="90%" cellpadding="2">

            <thead>
            <tr>
                <th width="50px" style="text-align: center; font-size: 10px; font-weight: bold"></th>

                <th width="230px"  style="text-align: center; font-size: 10px; font-weight: bold; border: 1px solid black;">Scheduled Attendance</th>              
               
                <th width="295px" style="text-align: center; font-size: 10px; font-weight: bold; border: 1px solid black;">Overtime</th>               
                
            </tr>

            <tr class="row-line">
            <th width="50px" style="text-align: center; font-size: 10px; font-weight: bold">Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Shift</th>
                <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">Entry <br/> Time</th>
                <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">Exit <br/> Time</th>
                <th width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Late</th>
                <th width="45px" style="text-align: center; font-size: 10px; font-weight: bold">Status</th>

                <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">Near OT<br/>Entry<br/>Punch</th>
                <th width="80px" style="text-align: center; font-size: 10px; font-weight: bold">OT<br/>Time</th>
                <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">Near OT<br/>Exit<br/>Punch</th>
                
                <th width="45px" style="text-align: center; font-size: 10px; font-weight: bold">Applied<br>OT<br/>hour</th>
                <th width="45px" style="text-align: center; font-size: 10px; font-weight: bold">Aproved<br/>hour</th>
                <th width="45px" style="text-align: center; font-size: 10px; font-weight: bold">Rejected<br/>hour</th>
                
            </tr>
            </thead>
            <tbody>            
            @foreach($data as $row)
            
            @foreach($Overtimedata as $ov)
            <!-- @if ($row->attend_date == $ov->ot_date)   -->
                @php
                $overtime_entry_time = strtotime($ov->ot_date .' '.$ov->entry_time);
                $overtime_exit_time = strtotime($ov->ot_date .' '.$ov->exit_time);

                $max_entry = strtotime('+1 hour',$overtime_entry_time);
                $min_entry = strtotime('-1 hour',$overtime_entry_time);

                $max_exit = strtotime('+1 hour',$overtime_exit_time);
                $min_exit = strtotime('-1 hour',$overtime_exit_time);
                            
                $max_entry_time = date("Y-m-d H:i:s",$max_entry);
                $min_entry_time = date("Y-m-d H:i:s",$min_entry);

                $max_exit_time = date("Y-m-d H:i:s",$max_exit);
                $min_exit_time = date("Y-m-d H:i:s",$min_exit);
 
                $nearest_entry = $punches->where('employee_id',$ov->employee_id)
                                        ->where('attendance_datetime','>=',$min_entry_time)
                                        ->where('attendance_datetime','<=',$max_entry_time)
                                        ->first();

                $nearest_exit = $punches->where('employee_id',$ov->employee_id)
                                        ->where('attendance_datetime','>=',$min_exit_time)
                                        ->where('attendance_datetime','<=',$max_exit_time)
                                        ->first();

                $near_ot_entry = empty($nearest_entry->att_time) ? '' : \Carbon\Carbon::parse($nearest_entry->att_time)->format('g:i A');

                $near_ot_exit = empty($nearest_exit->att_time) ? '' : \Carbon\Carbon::parse($nearest_exit->att_time)->format('g:i A');

                $ot_entry = is_null($ov->entry_time) ? '' : \Carbon\Carbon::parse($ov->entry_time)->format('g:i A');

                $ot_exit = is_null($ov->exit_time) ? '' : \Carbon\Carbon::parse($ov->exit_time)->format('g:i A');

                @endphp

                    <tr>
                 
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! \Carbon\Carbon::parse($row->attend_date)->format('d-M-Y') !!}</td>
                        <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->shift_id == 1 ? 'Off Day' : \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') . '-' . \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                        <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! is_null($row->entry_time) ? '' : \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!}</td>
                        <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! is_null($row->exit_time) ? '' : \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!}</td>
                        <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->late_minute !!}</td>
                        @if($row->leave_flag && $row->offday_flag == 1 || $row->leave_flag && $row->holiday_flag == 1)
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! ($row->offday_flag == 1  ? '' : ($row->holiday_flag == 1 ? '': 'Absent')) !!}{!! $row->leave->short_code !!}</td>

                        @else
                            <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->attend_status == 'P' ? 'Present' : ($row->offday_flag == 1 ? 'Off Day' : ($row->holiday_flag == 1 ? 'Public Holiday' : ($row->leave_id  == 1  ? 'CL' : ($row->leave_id  == 2  ? 'SL' : ($row->leave_id  == 3  ? 'AL' :($row->leave_id  == 4  ? 'EL' :($row->leave_id  == 5  ? 'ML' :($row->leave_id  == 9  ? 'LWP' :'Absent' )))))))) !!}</td>
                        @endif                    
                       
                        <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $near_ot_entry !!}</td>


                        <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $ot_entry !!} - {!! $ot_exit !!}</td>

                        <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $near_ot_exit !!}</td>

                        <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $ov->ot_hour !!}</td>
                        
                        @if($ov->finalize_by !=null && $ov->status == 1 )
                        <td width="45px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $ov->actual_overtime_hour !!}</td>
                        @else
                        <td width="45px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! 0 !!}</td>
                        @endif


                        @if($ov->finalize_by !=null && $ov->status == 0 )
                        <td width="45px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $ov->ot_hour !!}</td>
                        @else
                        <td width="45px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! 0 !!}</td>
                        @endif
                    </tr>
                    <!-- @endif -->
        @endforeach  
                   
            @endforeach   
                    
            </tbody>
        </table>
       
        <div class="blank-space"></div>
    @endif

<div class="blank-space"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}



</body>

@section('scripts')
  <script type="text/javascript">
$(function() {  
//Created By: Brij Mohan
//Website: http://techbrij.com
function groupTable($rows, startIndex, total){
if (total === 0){
return;
}
var i , currentIndex = startIndex, count=1, lst=[];
var tds = $rows.find('td:eq('+ currentIndex +')');
var ctrl = $(tds[0]);
lst.push($rows[0]);
for (i=1;i<=tds.length;i++){
if (ctrl.text() ==  $(tds[i]).text()){
count++;
$(tds[i]).addClass('deleted');
lst.push($rows[i]);
}
else{
if (count>1){
ctrl.attr('rowspan',count);
groupTable($(lst),startIndex+1,total-1)
}
count=1;
lst = [];
ctrl=$(tds[i]);
lst.push($rows[i]);
}
}
}
groupTable($('#myTable tr:has(td)'),0,4);
$('#myTable .deleted').remove();
});
</script>
@endsection


</html>

