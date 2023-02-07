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

{{--<div>--}}
    {{--<table style="width:100%">--}}
        {{--<tr>--}}
            {{--<td style="width:10%"></td>--}}
            {{--<td style="width:80%">--}}
                {{--<table style="width:100%" class="order-bank">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">List of Participant : {!! $training->training->title !!}</span></td>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                {{--</table>--}}
            {{--</td>--}}
            {{--<td style="width:10%"></td>--}}
        {{--</tr>--}}
    {{--</table>--}}
{{--</div>--}}
@if (!empty($trainees))

<table class="table order-bank table-bordered" width="90%" cellpadding="2">

            <tbody>

<tr class="row-line">
    <td width="60%" style="font-weight: bold;font-size:11pt; text-align: left">Training Title : {!! $training->training->title !!} <br/>
        Schedule : {!! $training->start_from !!} To {!! $training->end_on !!}
    </td>

    <td width="60%" style="font-weight: bold;font-size:11pt; text-align: left">
        Total Participant : {!! $training->participants !!}<br/>
        Total Attended :    {!! $training->attended !!}
      <br/>
    
        {!! $time === 'A' ? 'Attended : '.$dept->attended : null !!}
    </td>

</tr>
</tbody>
</table> 
<div class="blank-space"></div>
@foreach($participants  as $i=>$dept)

    
  
       
<div class="blank-space"></div>
        <table class="table order-bank table-bordered" width="90%" cellpadding="2">

            <tbody>

<tr class="row-line">
    <td width="60%" style="font-weight: bold;font-size:11pt; text-align: left">Department : {!! $dept->department->name !!} <br/>
        
    </td>
<td>
</td>
    <td width="60%" style="font-weight: bold;font-size:11pt; text-align: left"> Attended : {!! $dept->attended !!}
        
      <br/>
    
        {!! $time === 'A' ? 'Attended : '.$dept->attended : null !!}
    </td>

</tr>
</tbody>
</table> 

<table class="table order-bank table-bordered" width="90%" cellpadding="2">   
            
            <tbody>
            <tr class="row-line">
                    <th width="30px" style="font-size:10pt; text-align: left">SL</th>
                    <th width="60px" style="font-size:10pt; text-align: left">ID</th>
                    <th width="150px" style="font-size:10pt; text-align: left">Name</th>
                    <th width="120px" style="font-size:10pt; text-align: left">Designation</th>
                    <th width="50px" style="font-size:10pt; text-align: left">{!! $time ==='B' ? 'Signature' : 'Attend' !!}</th>
                    <th width="100px" style="font-size:10pt; text-align: left">Evaluation</th>
                </tr>
            @php($x=0)
            @foreach($trainees as $person)
            @if($dept->department_id == $person->department_id)
           
                    @php($x ++)
               

                    <tr class="row-line" style="line-height: 250%">
                        <td width="30px" style="font-size:10pt; text-align: left">{!! $x !!}</td>
                        <td width="60px" style="font-size:10pt; text-align: left">{!! $person->employee_id !!}</td>
                        <td width="150px" style="font-size:10pt; text-align: left">{!! $person->personal->full_name !!}</td>
                        <td width="120px" style="font-size:10pt; text-align: left">{!! $person->designation->name !!}</td>
                        <td width="50px"style="font-size:10pt; text-align: left">{!! $person->trainee->attended === 1 ? 'Yes' : null !!}</td>
                        <td width="100px" style="font-size:10pt; text-align: left">{!! $person->trainee->evaluation !!}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
            </table>
    @endforeach
       

    <br pagebreak="true">
    @endif
  


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

