<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
<div class="blank-space"></div>
<div class="blank-space"></div>

{{--<table border="0" cellpadding="0">--}}
{{--<tbody>--}}
{{--<tr>--}}
{{--<td width="11%"></td>--}}
{{--<td width="80%"><img src="{!! $data->image !!}" width="400" height="410"></td>--}}
{{--<td width="5%"></td>--}}
{{--</tr>--}}
{{--</tbody>--}}
{{--</table>--}}




<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
{{--<div class="blank-space"></div>--}}


@if(strlen($data->full_name) < 22)
    <table border="0" cellpadding="0">
        <tbody>

        <tr>
            <td width="85%" style="margin: 0px; padding: 0px; text-align: center; font-size:50px; color: white; font-weight: bold;">{!!trim($data->full_name) !!}</td>
        </tr>
        <div class="blank-hspace"></div>
        <tr>
            <td width="85%" style="text-align: center; font-size:30pt; color: white; font-weight: bold">{!! $data->professional->designation->name !!}</td>
        </tr>

        <tr>
            <td width="85%" style="text-align: center; font-size:30pt; color: white; font-weight: bold">{!! $data->professional->department->name !!}</td>
        </tr>

        </tbody>
    </table>
@endif

@if(strlen($data->full_name) >= 22 && strlen($data->full_name) < 28)
    <table border="0" cellpadding="0" class="order-bank">
        <tbody>
        <tr>
            <td width="85%" style="text-align: center; font-size:40px; color: white; font-weight: bold">{!! trim($data->full_name) !!}</td>
        </tr>
        <div class="blank-hspace"></div>
        <tr>
            <td width="85%" style="text-align: center; font-size:30pt; color: white; font-weight: bold">{!! $data->professional->designation->name !!}</td>
        </tr>

        <tr>
            <td width="85%" style="text-align: center; font-size:30pt; color: white; font-weight: bold">{!! $data->professional->department->name !!}</td>
        </tr>

        </tbody>
    </table>
@endif

@if(strlen($data->full_name) >= 28)
    <table border="0" cellpadding="0" class="order-bank">
        <tbody>
        <tr>
            <td width="85%" style="text-align: center; font-size:30px; color: white; font-weight: bold">{!! trim($data->full_name) !!}</td>
        </tr>
        <div class="blank-hspace"></div>
        <tr>
            <td width="85%" style="text-align: center; font-size:30pt; color: white; font-weight: bold">{!! $data->professional->designation->name !!}</td>
        </tr>

        <tr>
            <td width="85%" style="text-align: center; font-size:30pt; color: white; font-weight: bold">{!! $data->professional->department->name !!}</td>
        </tr>

        </tbody>
    </table>
@endif




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

