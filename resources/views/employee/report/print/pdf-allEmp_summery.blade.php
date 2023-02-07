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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-size:15pt;color:#000000; ">Employee Summery Between :{{ $from_date }} to {{ $to_date }}</span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>

            <tr class="row-line">
                <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="200px" style="text-align: left; font-size: 10px; font-weight: bold">Working Status</th>
                <th width="150px" style="text-align: left; font-size: 10px; font-weight: bold">Total Employee</th>
                <th width="50px" style="text-align: right; font-size: 10px; font-weight: bold">Remark</th>
            </tr>
            </thead>
            <tbody>
                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">1 </td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">New Employee</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold;text-align: left">{!! $new_emp->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">2</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt;font-weight: bold; text-align: left">Regular</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $regular->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">3</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Probationary</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $probationary->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">4</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Suspended</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $suspended->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">5</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Resigned</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $resigned->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">6</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Terminated</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $terminated->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">7</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Unauthorised Absent</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $u_absent->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">8</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Contractual</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $contractual->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">9</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">Dismissed</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $dismissed->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>

                    <tr>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">10</td>
                        <td width="200px" style="border-bottom-width:1px; font-size:8pt;font-weight: bold;  text-align: left">Discontinued</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; font-weight: bold; text-align: left">{!! $discontinued->count() !!}</td>
                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td>
                    </tr>
            </tbody>
        </table>
    
        <div class="blank-space"></div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

