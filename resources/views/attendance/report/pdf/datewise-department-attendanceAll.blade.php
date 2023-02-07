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

<h3 style="font-weight: bold"> Report Title: All Department Attendance Report of the date : {!! $data[0]->attend_date !!}</h3>


            <table class="table table-info table-striped order-bank">

                <thead>
                    <tr class="row-line">
                        <th style="text-align: left; font-size: 11px; font-weight: bold">SL</th>
                        <th style="text-align: left; font-size: 11px; font-weight: bold">Department</th>
                        <td>Total</td>
                        <th style="text-align: left; font-size: 11px; font-weight: bold">Present</th>
                        <th style="text-align: left; font-size: 11px; font-weight: bold">Off Day</th>
                        <th style="text-align: left; font-size: 11px; font-weight: bold">In Leave</th>
                        <th style="text-align: left; font-size: 11px; font-weight: bold">Public Holiday</th>
                        <th style="text-align: left; font-size: 11px; font-weight: bold">Absent</th>

                    </tr>
                </thead>
                <tbody>
                @foreach($data as $i=>$row)
                    <tr class="row-line">
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $i + 1 !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->department->name !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->emp_count !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->present !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->offday !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->n_leave !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->holiday !!}</td>
                        <td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $row->absent !!}</td>
                    </tr>

                    {{--@php($t_emp = $t_emp+)--}}
                @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #0e4377">
                        <td colspan="2">Total</td>
                        <td>{!! $data->sum('emp_count') !!}</td>


                        <td>{!! $data->sum('present') !!}</td>
                        <td>{!! $data->sum('offday') !!}</td>
                        {{--<td style="border-bottom-width:1px; font-size:9pt; text-align: left">{!! $data->sum('n_leave') !!}</td>--}}

                        <td>{!! $data->sum('n_leave') !!}</td>
                        <td>{!! $data->sum('holiday') !!}</td>
                        <td>{!! $data->sum('absent') !!}</td>
                    </tr>
                </tfoot>
            </table>

        @endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>

