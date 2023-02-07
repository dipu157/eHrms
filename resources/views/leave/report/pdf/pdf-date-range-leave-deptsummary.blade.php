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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">

                       Department Wise  Leave Report </span>  </td>
                    </tr>
                   
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:11pt;color:#000000; "> Date From {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To  {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}<br/>
                        </span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>

      

@foreach($departments as $i=>$dept)

@if($data->contains('department_id',$dept->department_id))

   

    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        <tr>
            <th style="text-align: left; font-size: 10px; font-weight: bold">Department : {!! $dept->department->name !!} </th>
        </tr>
        <tr class="row-line">
            <th width="18px" style="text-align: center; font-size: 10px; font-weight: bold">SL</th>
            <th width="25px" style="text-align: center; font-size: 10px; font-weight: bold">PF</th>
            <th width="40px" style="text-align: center; font-size: 10px; font-weight: bold">ID</th>
            <th width="130px" style="text-align: center; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Status</th>
            <th width="140px" style="text-align: center; font-size: 10px; font-weight: bold">Designation</th>
            <th width="55px" style="text-align: center; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="50px" style="text-align: center; font-size: 10px; font-weight: bold">Leave</th>
           
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)

        @foreach($data as $row)
        
            @if($dept->department_id == $row->department_id)
            @php($dptname = $dept->where('department_id',$row->department_id))
            <tr>
                    <td width="18px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $sl !!}</td>
                    <td width="25px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->pf_no !!}</td>
                    <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->employee_id !!}</td>
                    <td width="130px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                    @if($row->professional->working_status_id == 1)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Regular</td>
                        @elseif($row->professional->working_status_id == 2)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Probationary</td>
                        @elseif($row->professional->working_status_id == 3)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Suspended</td>
                        @elseif($row->professional->working_status_id == 4)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Resigned</td>
                        @elseif($row->professional->working_status_id == 5)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Terminated</td>
                        @elseif($row->professional->working_status_id== 6)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Retired</td>
                        @elseif($row->professional->working_status_id== 7)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Unauthorised absent</td>
                        @elseif($row->professional->working_status_id== 8)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Contractual</td>
                        @elseif($row->professional->working_status_id == 9)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Dismissed</td>
                        @elseif($row->professional->working_status_id == 11)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Discontinued</td>
                        @elseif($row->professional->working_status_id == 12)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Dead</td>
                        @elseif($row->professional->working_status_id== 13)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Contract Mutual End
</td>
@elseif($row->professional->working_status_id == 14)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center">Released
</td>

                        @endif
                    <td width="140px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->designation->name !!} </td>
                    <td width="55px" style="border-bottom-width:1px;font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
                    <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->totaleave !!}</td>
                   
                </tr>
                @php($sl++)
               
            @endif
         
        @endforeach
        </tbody>
    </table>
   
 
    <div class="blank-space"></div>
  
    <div>Department Leave Employees</span>: {!! $sl -1 !!}</div>
    <div class="blank-space"></div>
@endif


@endforeach

<div>Total Leave Employees : {!! $data->count() !!}</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

