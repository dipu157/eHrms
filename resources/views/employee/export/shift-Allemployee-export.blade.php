<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">


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


<span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">Shifting Schedule : {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!} <br/>
</span>

    
</div>
<div class="blank-space"></div>

<span style="text-align:center; font-family:times;font-weight:bold;font-size:14pt;color:#000000; "> Hospital Management </span> <br>

<table style="width:100%;" class="table order-bank" cellpadding="2">
    <thead>
        <tr class="row-line">
            <th width="100px" style="text-align: left; font-size: 8px;" rowspan="4">Overall Supervision          General Shift  (9:00am--6:00pm)<br/></th>
            <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">PF NO</th>
            <th width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
        </tr>
    </thead>
    
    <tbody>
        <tr>
            <td width="100px"></td>
            <td width="70px" style="border-bottom-width:1px; border-left-width:1px; font-size:8pt; text-align: left">7191967</td>
            <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">2098</td>
            <td width="120px" style="border-bottom-width:1px; font-size:8pt; text-align: left">Dr. Ahmed Shafiqul Haider </td>
            <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left">Chief Executive Officer </td>
            <td width="80px" style="border-bottom-width:1px; border-right-width:1px; font-size:8pt; text-align: left">2019-03-13  </td>
        </tr>
    </tbody>
</table>

<br><br>

                
  @foreach($departments as $i=>$dept)

    @if($data->contains('department_id',$dept->department_id))
   
            @php($dptname = $data->where('department_id',$dept->department_id))
            {{--@php($depart = $department->where('id',$dept->department_id--}}
                <table style="width:100%" class="order-bank">
                    <thead>
                        <tr>
                          <td style="width:100%;" ><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">Department : {!! $dept->department->name !!} <br/>
                            </span></td>                        
                        </tr>            
                    </thead>
                </table>
                <div class="blank-space"></div>                
 
    @if($dptname->contains('employee_id',$dept->department->headed_by))

        <table class="table order-bank" width="100%" cellpadding="2">

        <thead>

        <tr class="row-line">
            <th width="80px" style="text-align: left; font-size: 8px;" rowspan="2">Overall Supervision          General Shift  (9:00am--6:00pm)</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">PF NO</th>
            <th width="110px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="90px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="90px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">Status</th>
            
          
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)


@foreach($dptname as $row)
     @if($row->employee_id == $dept->department->headed_by)

        <tr>
            <td width="80px"></td>
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
            <td width="110px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
            <td width="90px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
            <td width="90px" style="border-bottom-width:1px; border-right-width:1px; font-size:8pt; text-align: left">{!!$row->professional->joining_date!!}</td>


            @if($row->leave_flag && $row->offday_flag == 1 || $row->leave_flag && $row->holiday_flag == 1)
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! ($row->offday_flag == 1  ? '' : ($row->holiday_flag == 1 ? '': 'Absent')) !!}{!! $row->leave->short_code !!}</td>

                        @else
                            <td width="50px" style="border-bottom-width:1px; border-right-width:1px; font-size:8pt; text-align: center">{!! $row->attend_status == 'P' ? 'Present' : ($row->offday_flag == 1 ? 'Off Day' : ($row->holiday_flag == 1 ? 'Public Holiday' : ($row->leave_id  == 1  ? 'CL' : ($row->leave_id  == 2  ? 'SL' : ($row->leave_id  == 3  ? 'AL' :($row->leave_id  == 4  ? 'EL' :($row->leave_id  == 5  ? 'ML' :($row->leave_id  == 8  ? 'SPL':($row->leave_id  == 9 ? 'LWP':($row->leave_id  == 6  ? 'QL' :'Absent' )))))))))) !!}</td>
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

      
@if($dptname->contains('shift_id',$spt->shift_id))

    {{--<div>Department : {!! $dept->name !!} :  {!! $data->count() !!}</div>--}}
   
    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        <tr>
            <th style="text-align: center; font-size: 10px; font-weight: bold"> {!! $spt->shift->name !!}-({!! \Carbon\Carbon::parse($spt->shift->from_time)->format('g:i A') !!}--{!! \Carbon\Carbon::parse($spt->shift->to_time)->format('g:i A') !!}) </th>

        </tr>
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th> 
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">PF No</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="100px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="100px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="50px" style="text-align: center; font-size: 10px; font-weight: bold">Status</th>
            <th width="70px" style="text-align: center; font-size: 10px; font-weight: bold">Status</th>
            
          
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)

       
        @foreach($dptname as $row)
            @if($spt->shift_id == $row->shift_id)

                <tr>
                    <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
                    <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>                   
                    <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="100px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                    <td width="100px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                    <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!!$row->professional->joining_date!!}</td>
                    
                    @if($row->leave_flag && $row->offday_flag == 1 || $row->leave_flag && $row->holiday_flag == 1)
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! ($row->offday_flag == 1  ? '' : ($row->holiday_flag == 1 ? '': 'Absent')) !!}{!! $row->leave->short_code !!}</td>

                        @else
                        <td width="50px" style="border-bottom-width:1px; border-right-width:1px; font-size:8pt; text-align: center">{!! $row->attend_status == 'P' ? 'Present' : ($row->offday_flag == 1 ? 'Off Day' : ($row->holiday_flag == 1 ? 'Public Holiday' : ($row->leave_id  == 1  ? 'CL' : ($row->leave_id  == 2  ? 'SL' : ($row->leave_id  == 3  ? 'AL' :($row->leave_id  == 4  ? 'EL' :($row->leave_id  == 5  ? 'ML' :($row->leave_id  == 8  ? 'SPL':($row->leave_id  == 9 ? 'LWP':($row->leave_id  == 6  ? 'QL' :'Absent' )))))))))) !!}</td>
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

 Manpower </span>: {!! $dptname->count() !!}
 <div class="blank-space"></div>
    @endif
    @endforeach
    
    <div class="blank-space"></div>
Total Manpower </span>: {!! $employees->count()+1 !!}

<div class="blank-space"></div>
<div class="blank-space"></div>







<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>