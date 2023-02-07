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
            <td style="width:10%"></td>
            <td style="width:80%">
                <table style="width:100%" class="order-bank">
                    <thead>
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">Employee List For The Date : {!! $date !!}</span>
                        </td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:10%"></td>
        </tr>
    </table>
</div>

{{-- No Department Selected --}}

@if(!empty($employees) && $departments != null)
    @php($t_count = 0)
    @foreach($departments as $dept)

    @if($shiftId == null)
        <div style="text-align:center; font-family:times;font-weight:bold;font-size:12pt;">
            {!! $dept->department->name !!}
        </div>

        <table class="table order-bank" width="90%" cellpadding="2">
                <thead>
                <tr class="row-line">
                    <th width="40px" style="text-align: left; font-size: 10px">SL</th>
                    <th width="60px" style="text-align: left; font-size: 10px">ID</th>
                    <th width="150px" style="text-align: left; font-size: 10px">Name</th>
                    <th width="140px" style="text-align: left; font-size: 10px">Designation</th>
                    <th width="100px" style="text-align: left; font-size: 10px">Roster</th>
                </tr>
                </thead>
                <tbody>

                @php($count = 1)


                @foreach($employees as $i=>$row)
                    @if($row->department_id == $dept->department_id)

                        <tr>
                            <td width="40px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $count !!}</td>
                            <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->employee_id !!}</td>
                            <td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>
                            <td width="140px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->designation->name !!}</td>
                            <td width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! get_shift_name_one_line($row->roster->{$field}) !!} {!! $row->roster->{$field} !!}</td>
                        </tr>
                        @php($count ++)
                        @php($t_count ++)
                    @endif
                @endforeach
                </tbody>
            </table>

        <div class="blank-space"></div>
    

    @elseif($shiftId != null)
        <div style="text-align:center; font-family:times;font-weight:bold;font-size:12pt;">
            {!! $dept->department->name !!} <br> Shift Name : {!! get_shift_name_one_line($shiftId) !!}
        </div>

        <table class="table order-bank" width="90%" cellpadding="2">
                <thead>
                <tr class="row-line">
                    <th width="40px" style="text-align: left; font-size: 10px">SL</th>
                    <th width="60px" style="text-align: left; font-size: 10px">ID</th>
                    <th width="150px" style="text-align: left; font-size: 10px">Name</th>
                    <th width="140px" style="text-align: left; font-size: 10px">Designation</th>
                </tr>
                </thead>
                <tbody>

                @php($count = 1)


                @foreach($employees as $i=>$row)
                    @if($row->department_id == $dept->department_id)

                        <tr>
                            <td width="40px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $count !!}</td>
                            <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->employee_id !!}</td>
                            <td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>
                            <td width="140px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->designation->name !!}</td>
                        </tr>
                        @php($count ++)
                        @php($t_count ++)
                    @endif
                @endforeach
                </tbody>
            </table>

        <div class="blank-space"></div>
    @endif

    @endforeach
    <div>Grand Total : {!! $t_count !!}</div>

{{-- Department Selected --}}
@elseif(!empty($employees) && $departments == null)
    
    @php($t_count = 0)

    @if($shiftId != null)
        <div style="text-align:center;margin-bottom: 15px; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">
            Department Name  : {!! $departmentName[0] !!} <br> Shift Name : {!! get_shift_name_one_line($shiftId) !!}
        </div><br>

        <table class="table order-bank" cellpadding="2">
                <thead>
                <tr class="row-line">
                    <th width="40px" style="text-align: left; font-size: 10px">SL</th>
                    <th width="60px" style="text-align: left; font-size: 10px">ID</th>
                    <th width="150px" style="text-align: left; font-size: 10px">Name</th>
                    <th width="140px" style="text-align: left; font-size: 10px">Designation</th>
                </tr>
                </thead>
                <tbody>

                @php($count = 1)


                @foreach($employees as $i=>$row)

                        <tr>
                            <td width="40px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $count !!}</td>
                            <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->employee_id !!}</td>
                            <td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>
                            <td width="140px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->designation->name !!}</td>
                        </tr>
                        @php($count ++)
                        @php($t_count ++)
                @endforeach
                </tbody>
        </table>

    @elseif($shiftId == null)
        <div style="text-align:center;margin-bottom: 15px; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">
            Department Name  : {!! $departmentName[0] !!}
        </div><br>

        <table class="table order-bank" cellpadding="2">
                <thead>
                <tr class="row-line">
                    <th width="40px" style="text-align: left; font-size: 10px">SL</th>
                    <th width="60px" style="text-align: left; font-size: 10px">ID</th>
                    <th width="150px" style="text-align: left; font-size: 10px">Name</th>
                    <th width="140px" style="text-align: left; font-size: 10px">Designation</th>
                    <th width="100px" style="text-align: left; font-size: 10px">Roster</th>
                </tr>
                </thead>
                <tbody>

                @php($count = 1)


                @foreach($employees as $i=>$row)

                        <tr>
                            <td width="40px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $count !!}</td>
                            <td width="60px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->employee_id !!}</td>
                            <td width="150px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>
                            <td width="140px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! $row->designation->name !!}</td>
                            <td width="100px" style="border-bottom-width:1px; font-size:10pt; text-align: left">{!! get_shift_name_one_line($row->roster->{$field}) !!} {!! $row->roster->{$field} !!}</td>
                        </tr>
                        @php($count ++)
                        @php($t_count ++)
                @endforeach
                </tbody>
        </table>
    @endif

        <div class="blank-space"></div>

    <div>Grand Total : {!! $t_count !!}</div>
@endif



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

