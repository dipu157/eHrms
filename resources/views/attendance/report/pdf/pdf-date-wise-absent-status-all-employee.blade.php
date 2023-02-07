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
        <td width="35%"><img src="{!! public_path('/assets/images/Logobrb.png') !!}" style="width:270px;height:65px;"></td>
        <td width="2%"></td>
        <td width="58%" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br/> West Panthapath, Dhaka-1215</span></td>

    </tr>
    <hr style="height: 2px">

</table>

<div class="blank-space"></div>    
<div class="blank-space"></div>


<span style="text-align:center; font-family:times;font-weight:bold;font-size:14pt;color:#000000; "> Daily Absent Status of the Employees </span> <br>
<span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">Report Date : {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!} <br/></span>

@php
    $t_absent = $leave->count() + $inform_absent->count() + $absent->count() + $resigned->count() + $suspend->count();
    $t_employee = $data->count();
@endphp

    
</div>
   
    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-left-width: 1px; text-align: center; font-size: 12px; font-weight: bold">a) List of approved on leave employees ( {{ number_format((($leave->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Leave Type</th>
        </tr>
        </thead>

        <tbody>

        @php($sl = 1)

        @foreach($leave as $row)

            <tr>                   
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->joining_date !!} </td>
                <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->department->name!!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">{!! $row->shift->short_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center;"> {!! $row->leave->short_code !!}</td>
            </tr>
        
        @php($sl++)
        @endforeach

        </tbody>
        <tfoot>
            <div class="blank-space"></div>
            <tr>
                <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total In Leave : {{ $leave->count() }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="blank-space"></div>
    <div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-width: 1px; text-align: center; font-size: 12px; font-weight: bold">b) List of informed absentees who will join after approval by the authority: ( {{ number_format((($inform_absent->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Reason</th>           
        </tr>
        </thead>

        <tbody>        

        @foreach($inform_absent as $row)

            <tr>                   
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->joining_date !!} </td>
                <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->department->name!!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">{!! $row->shift->short_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center"> {!! $row->informAbsent->reason !!} </td>
            </tr>
        
        @php($sl++)
        @endforeach

        </tbody>
        <tfoot>
            <div class="blank-space"></div>
            <tr>
                <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total Inform Absent : {{ $inform_absent->count() }}</td>
            </tr>
            <div class="blank-space"></div>
        </tfoot>
    </table>

    <div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-width: 1px; text-align: center; font-size: 12px; font-weight: bold">c) List of employee under Home Quarantine/Isolation ( {{ number_format((($Qleave->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Leave Type</th>
        </tr>
        </thead>

        <tbody>
        

        @foreach($Qleave as $row)

            <tr>        
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->joining_date !!} </td>
                <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->department->name!!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">{!! $row->shift->short_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center;"> Home Quarentine </td>
            </tr>
        
        @php($sl++)
        @endforeach

        </tbody>
        <tfoot>
            <div class="blank-space"></div>
            <tr>
                <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total Quarentine Employee : {{ $Qleave->count() }}</td>
            </tr>
            <div class="blank-space"></div>
        </tfoot>
    </table>

    <div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-width: 1px; text-align: center; font-size: 12px; font-weight: bold">d) List of unauthorized absentees who will join after approval by the authority: ( {{ number_format((($absent->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Reason</th>
        </tr>
        </thead>

        <tbody>
        

        @foreach($absent as $row)

            <tr>             
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->joining_date !!} </td>
                <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->department->name!!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">{!! $row->shift->short_name !!} </td>
                
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center;"> Unauthorized </td>
            </tr>
        
        @php($sl++)
        @endforeach

        </tbody>
        <tfoot>
            <div class="blank-space"></div>
            <tr>
                <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total Unauthorised Absent : {{ $absent->count() }}</td>
            </tr>
            <div class="blank-space"></div>
        </tfoot>
    </table>

    <div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-width: 1px; text-align: center; font-size: 12px; font-weight: bold">e) List of note raised employees against Resignation: ( {{ number_format((($resigned->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Reason</th>
        </tr>
        </thead>

        <tbody>
        

        @foreach($resigned as $row)

            <tr>           
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->pf_no !!}</td>
                <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->joining_date !!} </td>
                <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation->name !!} </td>
                <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->department->name!!}</td>
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">No Shift </td>
                <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center;"> Resigned </td>
            </tr>
        
        @php($sl++)
        @endforeach

        </tbody>
        <tfoot>
            <div class="blank-space"></div>
            <tr>
                <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total Resigned : {{ $resigned->count() }}</td>
            </tr>
            <div class="blank-space"></div>
        </tfoot>
    </table>

    <div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-width: 1px; text-align: center; font-size: 12px; font-weight: bold">f) List of note raised employees against Suspend ( {{ number_format((($suspend->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
            
            <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Reason</th>
            </tr>
        </thead>

        <tbody>
            

            @foreach($suspend as $row)

                <tr>   
                    <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                    <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->pf_no !!}</td>
                    <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!} </td>
                    <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->joining_date !!} </td>
                    <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation->name !!} </td>
                    <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->department->name!!}</td>
                    <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">No Shift </td>                 
                    <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: center;"> Suspended</td>
                </tr>
            
            @php($sl++)
            @endforeach


        </tbody>

        <tfoot>
            <div class="blank-space"></div>
            <tr>
                    <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total Suspended : {{ $suspend->count() }}</td>
                </tr>
        </tfoot>
    </table>

    <div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">

        <span  width="150px" style="border-width: 1px; text-align: center; font-size: 12px; font-weight: bold">g) List of Maternity Leave ( {{ number_format((($Mleave->count()/$t_employee)*100), 2, '.', ',') }} %)</span><br><br>

        <thead>
        
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
            <th width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="75px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="85px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
            <th  width="30px" style="text-align: center; font-size: 10px; font-weight: bold">Shift</th>
            <th  width="65px" style="text-align: center; font-size: 10px; font-weight: bold">Leave Type</th>
        </tr>
        </thead>

        <tbody>
        

        @foreach($Mleave as $row)

            <tr>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>                       
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                <td width="105px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->joining_date !!} </td>
                <td width="75px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                <td  width="85px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->professional->department->name!!}</td>
                <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center;">{!! $row->shift->short_name !!} </td>
                <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: center;"> Maternity Leave </td>
            </tr>
        
        @php($sl++)
        @endforeach

        </tbody>
        <tfoot>
            <div class="blank-space"></div>
            <tr>
                <td colspan="4" style="font-size:10pt; text-align: right; font-weight: bold">Total Maternity Leave Absent : {{ $Mleave->count() }}</td>
            </tr>
            <div class="blank-space"></div>
        </tfoot>
    </table>

    <div class="blank-space"></div>
    <div class="blank-space"></div>

    <table class="table order-bank" width="60%" cellpadding="2">
        <tr class="row-line">
            <th>Total Manpower</th>
            <th>Total Absent</th>
            <th>Absentee %</th>
        </tr>
        <tr class="row-line">
            <th style="text-align: center;">{{ $t_employee }}</th>
            <th style="text-align: center;">{{ $t_absent }}</th>
            <th style="text-align: center;">{{ number_format((($t_absent/$t_employee)*100), 2, '.', ',') }}</th>
        </tr>
    </table>

    <div class="blank-space"></div>
    <div class="blank-space"></div>

    <span colspan="4" style="border-top-width: 1px; font-size:12pt; text-align: left; font-weight: bold">Manager-Administration</span>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>
