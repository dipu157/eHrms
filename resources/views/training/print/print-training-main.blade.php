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

@if(count($traineeList) > 0)

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



    <table class="table" width="100%" cellpadding="2">
        <tbody>

        <tr>
            <td style="font-size:10pt; text-align: left; font-weight: bold; text-align: center">Name of Employees Attended The Below Training</td>
        </tr>

        <tr>
            <td style="border-bottom-width:1px; font-size:10pt; text-align: left; font-weight: bold">Training Title : {!! $traineeList[0]->trainingSch->training->title !!}<br/>
                {!! $traineeList[0]->employee->department->name !!}</td>
        </tr>

        </tbody>
    </table>

    <table class="table order-bank table-bordered" width="90%" cellpadding="2">

        <thead>
        <tr class="row-line">
            <th width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">SL</th>
            <th width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">ID</th>
            <th width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Name</th>
            <th width="120px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Designation</th>
            <th width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Training Date</th>
        </tr>
        </thead>
        <tbody>
        @php($x=0)
        @foreach($traineeList as $person)

            {{--@if($person->department_id == $department->id )--}}
                @php($x ++)
                <tr class="row-line" style="line-height: 100%">
                    <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $x !!}</td>
                    <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $person->employee_id !!}</td>
                    <td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $person->employee->personal->full_name !!}</td>
                    <td width="120px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $person->employee->designation->name !!}</td>
                    <td width="100px"style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! \Carbon\Carbon::parse($person->trainingSch->start_from)->format('d-m-Y') !!}</td>
                    {{--<td width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $person->trainee->evaluation !!}</td>--}}
                </tr>
            {{--@endif--}}

        @endforeach
        </tbody>
    </table>
    <div class="blank-space"></div>
    <br pagebreak="true">
@endif

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

    <table class="table" width="100%" cellpadding="2">
        <tbody>

        <tr>
            <td style="font-size:10pt; text-align: left; font-weight: bold; text-align: center">Name of Employees Not Attended The Below Training</td>
        </tr>

        <tr>
            <td style="font-size:10pt; text-align: left; font-weight: bold">Training Title : {!! $training->title !!}<br/>
                {!! $emp_list[0]->department->name !!}</td>
        </tr>

        </tbody>
    </table>

    <table class="table order-bank table-bordered" width="90%" cellpadding="2">

        <thead>
        <tr class="row-line">
            <th width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">SL</th>
            <th width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">ID</th>
            <th width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Name</th>
            <th width="120px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Designation</th>
            <th width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: left">Remarks</th>
        </tr>
        </thead>
        <tbody>
        @php($x=0)
        @foreach($emp_list as $row)

            @if(!$traineeList->contains('employee_id',$row->$row))
                @php($x ++)
                <tr class="row-line" style="line-height: 100%">
                    <td width="30px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $x !!}</td>
                    <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>
                    <td width="120px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->designation->name !!}</td>
                    <td width="100px"style="border-bottom-width:1px; font-size:10pt; text-align: left"></td>
                    {{--<td width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $person->trainee->evaluation !!}</td>--}}
                </tr>
            @endif

        @endforeach
        </tbody>
    </table>


    {{--<br pagebreak="true">--}}
{{--@endforeach--}}



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

