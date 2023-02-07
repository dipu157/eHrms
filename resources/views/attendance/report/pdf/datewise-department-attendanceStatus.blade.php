<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Optional theme -->
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
            background: #ffdab9;
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

                            
@if(!empty($data))

                  
    <h3 style="font-weight: bold">Department Name : {!! $data[0]->department->name !!} <br/>

    Report Title: List Of Employees of the date : {!! $data[0]->attend_date !!} </h3> <br/>

    <table class="table table-secondary table-striped order-bank">

        <thead>
        <tr class="row-line">
            <th style="text-align: left; font-size: 11px; font-weight: bold">SL</th>
            <th style="text-align: left; font-size: 11px; font-weight: bold">ID</th>
            <th style="text-align: left; font-size: 11px; font-weight: bold">Name</th>
            <th style="text-align: left; font-size: 11px; font-weight: bold">Shift</th>
            <th style="text-align: left; font-size: 11px; font-weight: bold">Status</th>
        </tr>
        </thead>
        <tbody>
        @php($sl=0)
        @foreach($data as $i=>$row)
            @if($row->Status == 'OffDay')
                @php($sl++)
                <tr>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $sl !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->professional->personal->full_name !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->Status !!}</td>
                </tr>
            @endif

            @if($row->Status == 'InLeave')
                @php($sl++)
                <tr>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $sl !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->professional->personal->full_name !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->Status !!}</td>
                </tr>
            @endif


            @if($row->Status == 'Absent')
                @php($sl++)
                <tr>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $sl !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->professional->personal->full_name !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                    <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->Status !!}</td>
                </tr>
            @endif

        @endforeach
        </tbody>

        
    </table>

 @endif

<div class="blank-space"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>

