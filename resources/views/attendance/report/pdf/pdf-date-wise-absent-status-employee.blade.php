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
    
<div class="blank-space"></div>


<span style="text-align:center; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">Not Attendent Employee List </span> <br>
<span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">Report Date : {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!} <br/>
                        </span>

    
</div>

        @if($status  == 2 )
        <span style="font-size:12pt; text-align: left"><b>Informed Absent</b></span><br><br>

        @elseif($status  == 3)
        <span style="font-size:12pt; text-align: left"><b>Unauthorized Absent</b></span><br><br>


        @elseif($status  == 4)
        <span style="font-size:12pt; text-align: left"><b>In Leave</b></span><br><br>

        @elseif($status  == 5 )
        <span style="font-size:12pt; text-align: left"><b>Resigned</b></span><br><br>

        @elseif($status  == 6)
        <span style="font-size:12pt; text-align: left"><b>Suspended</b></span><br><br>
        @elseif($status  == 7)
        <span style="font-size:12pt; text-align: left"><b>Maternity Leave</b></span><br><br>
        @elseif($status  == 8)
        <span style="font-size:12pt; text-align: left"><b>Quarentine Leave</b></span><br><br>
      
        @endif
   
    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>            
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>            
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th width="55px" style="text-align: center; font-size: 10px; font-weight: bold">Reason</th>
        </tr>
        </thead>


        <tbody>
        @php($sl = 1)

        @if($status == 2 )
        @foreach($data as $row)

        <tr>
               
            <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>            
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!} </td>
            <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
            <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
            <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
            <td width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->department->name!!}</td>      
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->shift->short_name !!} </td>
            <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach 

        @elseif($status == 3)
        @foreach($data as $row)

        <tr>
               
            <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!} </td>
            <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
            <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
            <td width="75px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
            <td width="85px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->department->name!!}</td>      
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->shift->short_name !!} </td>
            <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach  

        @elseif($status  == 4 )
        @foreach($data as $row)

        <tr>
               
            <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!} </td>
            <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
            <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
            <td width="75px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
            <td width="85px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->department->name!!}</td>      
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->shift->short_name !!} </td>
            <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach

        @elseif($status  == 5 )
        @foreach($employees as $row)

        <tr>
               
            <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>           
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->pf_no !!} </td>
            <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!} </td>
            <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-M-Y') !!} </td>
            <td width="75px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation->name !!} </td>
            <td width="85px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->department->name!!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">No Shift </td>
            <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach 

        @elseif($status  == 6 )
        @foreach($employees as $row)

        <tr>
               
            <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
            <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->pf_no !!} </td>
            <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!} </td>
            <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-M-Y') !!} </td>
            <td width="75px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation->name !!} </td>
            <td width="85px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->department->name!!}</td>
            <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">No Shift </td>
            <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach          
     
        @elseif($status  == 7 )
        @foreach($employees as $row)

        <tr>
               
        <td width="20px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
        <td width="40px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
        <td width="30px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!} </td>
        <td width="105px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
        <td width="65px"  style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
        <td width="75px"   style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
        <td width="85px"   style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->department->name!!}</td>
        <td width="30px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->shift->short_name !!} </td>
        <td width="55px"  style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach          
      
        @elseif($status  == 8 )
        @foreach($employees as $row)

        <tr>
               
            <td width="20px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
            <td width="40px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
            <td width="30px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!} </td>
            <td width="105px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
            <td width="65px"  style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-M-Y') !!} </td>
            <td width="75px"   style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
            <td width="85px"   style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->department->name!!}</td>      
            <td width="30px"  style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->shift->short_name !!} </td>
            <td width="55px"  style="border-bottom-width:1px; font-size:8pt; text-align: left"> </td>
        </tr>
        @php($sl++)
        @endforeach          
        @endif
        </tbody>

        <div class="blank-space"></div>
        <div class="blank-space"></div>

        @if($status  == 1 || $status  == 2 || $status  == 3 || $status  == 4 )
        <span style="font-size:10pt; text-align: left; font-weight: bold">Total Not Attendent : {!! $data->count() !!}</span><br><br>

        {{-- @elseif($status  == 5 || $status == 6)
        <span style="font-size:10pt; text-align: left; font-weight: bold">Total Not Attendent : {!! $emploees->count() !!}</span><br><br> --}}

        @endif

        

                
    </table>      
           


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>
