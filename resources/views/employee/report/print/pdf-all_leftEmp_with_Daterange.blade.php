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
    <table style="width:100%">
        <tr>
            <td style="width:5%"></td>
            <td style="width:90%">
                <table style="width:100%" class="order-bank">
                    <thead>
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-size:15pt;color:#000000; ">All Left Employee Between :{{ $start_date }} to {{ $last_date }}<br/>Total Left : {!! $employees->count() !!}</span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


@foreach($departments as $i=>$dept)

    @if($employees->contains('department_id',$dept->department_id))


        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>
            <tr>
                <th style="text-align: left; font-size: 10px; font-weight: bold">Department : {!! $dept->department->name !!}</th>

            </tr>
            <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
                <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF</th>
                <th width="110px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
                <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
                <th width="60px" style="text-align: center; font-size: 10px; font-weight: bold">DOJ</th>
                <th width="65px" style="text-align: right; font-size: 10px; font-weight: bold">Status</th>
                <th width="60px" style="text-align: right; font-size: 10px; font-weight: bold">End Date</th>
                <th width="50px" style="text-align: right; font-size: 10px; font-weight: bold">Remark</th>
            </tr>
            </thead>
            <tbody>
            @php($sl = 1)
            
            @foreach($employees as $row)            
                @if($dept->department_id == $row->department_id)

                    <tr>
                        <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                        <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->pf_no !!}</td>
                        <td width="110px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!}</td>
                        <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation->name !!}</td>
                        <td width="60px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-M-Y') !!} </td>
                        @if($row->working_status_id == 1)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Regular</td>
                        @elseif($row->working_status_id == 2)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Probationary</td>
                        @elseif($row->working_status_id == 3)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Suspended</td>
                        @elseif($row->working_status_id == 4)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Resigned</td>
                        @elseif($row->working_status_id == 5)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Terminated</td>
                        @elseif($row->working_status_id == 6)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Retired</td>
                        @elseif($row->working_status_id == 7)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Unauthorised absent</td>
                        @elseif($row->working_status_id == 8)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Contractual</td>
                        @elseif($row->working_status_id == 9)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Dismissed</td>
                        @elseif($row->working_status_id == 11)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Discontinued</td>
                        @elseif($row->working_status_id == 12)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Dead</td>
                        @elseif($row->working_status_id == 13)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Contract Mutual End
</td>
@elseif($row->working_status_id == 14)
                        <td width="65px" style="border-bottom-width:1px; font-size:8pt; text-align: right">Released
</td>

                        @endif
                        <td width="60px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! \Carbon\Carbon::parse($row->status_change_date)->format('d-M-Y') !!} </td>
                        <th width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></th>

                    </tr>
                    @php($sl++)                                
                @endif
            @endforeach
            </tbody>
        </table>
        
        
        <div>Department Total </span>: {!! $sl -1 !!}</div>

        <div class="blank-space"></div>
    @endif


@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

