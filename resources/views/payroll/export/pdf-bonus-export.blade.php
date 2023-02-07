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
        tr.row-border td {
            border-bottom-width:1px;
            border-top-width:1px;
            border-right-width:1px;
            border-left-width:1px;
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

<div>
    <table style="width:100%">
        <tr>
            <td style="width:5%"></td>
            <td style="width:90%">
                <table style="width:100%" class="order-bank">
                    <thead>
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">Bonus For Eid ul-Adha {!! $period->calender_year !!}</span></td>
                    </tr>

                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>

    @if(!empty($bonus))
    @php($count=1)

    @foreach($departments as $dept)
        <div style="text-align: left; font-size: 10px; font-weight: bold">{!! $dept->department->name !!}</div>

                    <table class="table order-bank" width="90%" cellpadding="2">

                        <thead>

                        <tr class="row-line">
                            <th rowspan="2" width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                            <th rowspan="2" width="45px" style="text-align: left; font-size: 8px; font-weight: bold">ID</th>
                            <th rowspan="2" width="100px" style="text-align: left; font-size: 8px; font-weight: bold">Name</th>
                            <th rowspan="2" width="70px" style="text-align: left; font-size: 8px; font-weight: bold">Designation</th>
                            <th rowspan="2" width="65px" style="text-align: left; font-size: 8px; font-weight: bold">Joining Date</th>
                            <th width="45px" style="text-align: left; font-size: 8px; font-weight: bold">Basic</th>
                            <th width="50px" style="text-align: left; font-size: 8px; font-weight: bold">Bonus</th>
                            <th width="35px" style="text-align: left; font-size: 8px; font-weight: bold">Stamp Fee</th>
                            <th width="45px" style="text-align: left; font-size: 8px; font-weight: bold">Net Bonus</th>
                            <th width="50px" style="text-align: left; font-size: 8px; font-weight: bold">Remark</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($bonus as $row)
                                @if($dept->department_id == $row->department_id)

                                        <tr class="row-border">

                                            <td width="20px" style="font-size:8pt; text-align: left">{!! $count ++ !!}</td>
                                            <td width="45px" style="font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                                            <td width="100px" style="font-size:8pt; text-align: left">{!! $row->personal->full_name !!}</td>
                                            <td width="70px" style="font-size:8pt; text-align: left">{!! $row->designation->name !!}</td>

                                            <td width="65px" style="font-size:8pt; text-align: left">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-m-Y') !!}</td>
                                            <td width="45px" style="font-size:8pt; text-align: right">{!! number_format($row->bonus->basic ?? 0,0) !!}</td>
                                            <td width="50px" style="font-size:8pt; text-align: right">{!! number_format($row->bonus->bonus ?? 0,0) !!}</td>
                                            <td width="35px" style="font-size:8pt; text-align: right">{!! number_format($row->bonus->stamp_fee ?? 0,0) !!}</td>
                                            <td width="45px" style="font-size:8pt; text-align: right">{!! number_format($row->bonus->net_bonus ?? 0,0) !!}</td>
                                           
                                            <td width="50px"></td>

                                        </tr>
                                @endif

                            @endforeach
                        </tbody>

                    </table>
    @endforeach
    @endif

<div><span style="text-align: left; font-size: 12px; font-weight: bold">Grand Total</span></div>

<table class="table order-bank" width="90%" cellpadding="2">

    <tbody>

        <tr class="row-border">
            <td width="350px" style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold">Bonus</td>
            <td width="122px" style="border-bottom-width:1px; font-size:10pt; text-align: right; font-weight: bold">{!! number_format($bonus->sum('bonus.net_bonus')) !!}</td>
        </tr>
        

    </tbody>
</table>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

