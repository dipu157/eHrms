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
            /*background-color: #ffffff;*/
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
    </style>

</head>
<body>


<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>


<table border="0" cellpadding="0">
    <tbody>
    <tr>
        {{--<td width="10%"></td>--}}
        <td width="90%" style="text-align: center; font-size:30pt; color: black">This card is the property of</td>
    </tr>
    </tbody>

</table>

<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>


<table border="0" cellpadding="0">
    <tbody>
    <tr>
        <td width="5%"></td>
        <td width="27%" style="text-align: left; font-size:25px;  color: black">Blood Group</td>
        <td width="5%" style="text-align: left; font-size:25px; color: black">:</td>
        <td width="60%" style="text-align: left; font-size:25px; color: black">{!! $data->blood_group !!}</td>
    </tr>

    <tr>
        <td width="5%"></td>
        <td width="27%" style="text-align: left; font-size:25px; color: black">Pf No</td>
        <td width="5%" style="text-align: left; font-size:25px; color: black">:</td>
        <td width="60%" style="text-align: left; font-size:25px; color: black">{!! $data->professional->pf_no !!}</td>
    </tr>

    <tr>
        <td width="5%"></td>
        <td width="27%" style="text-align: left; font-size:25px; color: black">Joining Date</td>
        <td width="5%" style="text-align: left; font-size:25px; color: black">:</td>
        <td width="60%" style="text-align: left; font-size:25px; color: black">{!! $data->professional->joining_date  !!}</td>
    </tr>

    <tr>
        <td width="5%"></td>
        <td width="27%" style="text-align: left; font-size:25px; color: black">Employee ID</td>
        <td width="5%" style="text-align: left; font-size:25px; color: black">:</td>
        <td width="60%" style="text-align: left; font-size:25px; color: black">{!! $data->professional->employee_id !!}</td>
    </tr>

    <tr>
        <td width="5%"></td>
        <td width="27%" style="text-align: left; font-size:25px; color: black">National ID</td>
        <td width="5%" style="text-align: left; font-size:25px; color: black">:</td>
        <td width="60%" style="text-align: left; font-size:25px; color: black">{!! $data->national_id !!}</td>
    </tr>


    </tbody>

</table>

<div class="blank-space"></div>
<div class="blank-space"></div>

<table class="order-bank" cellpadding="0">
    <tbody>
    <tr>
        <td width="85%" style="text-align: center; font-size:25pt; color: black">If found please return to</td>
    </tr>
    </tbody>

</table>

<div class="blank-space"></div>

<table class="order-bank" cellpadding="0">
    <tbody>
    <tr>
        <td width="85%" style="text-align: center; font-size:25pt; color: black">77/A East Rajabazar, West Panthapath<br/>
            Dhaka 1215, Bangladesh<br>
            +88 02 9140333,+88 02 9140346<br>
            Cell: 01777 764824<br>
            brbhospitals@gmail.com


        </td>
    </tr>
    </tbody>

</table>

<div class="blank-space"></div>
<div class="blank-space"></div>

<table border="0" cellpadding="0">
    <tbody>
    <tr>
        <td width="1%"></td>
        <td width="40%" style="text-align: center;"><img src="{!! asset($data->signature) !!}" width="200pt" height="40pt"></td>
        {{--<td width="40%" style="text-align: center; font-size:20pt;"></td>--}}
        <td width="10%" style="text-align: left; font-size:20pt;"></td>
        <td width="40%" style="text-align: left; font-size:20pt;"><img src="{!! public_path('cardphoto/chairmansirign.png') !!}" width="160px" height="40px"></td>

    </tr>

    {{--<tr>--}}
        {{--<td width="3%"></td>--}}
        {{--<td width="35%" style="border-top-width:1px; text-align: center; font-size:20pt; color: black">Holders Signature</td>--}}
        {{--<td width="5%" style="text-align: left; font-size:20pt;"></td>--}}
        {{--<td width="40%" style="border-top-width:1px; text-align: center; font-size:20pt; color: black">Authorized Signature</td>--}}
        {{--<td width="12%"></td>--}}
    {{--</tr>--}}

    </tbody>

</table>

<table class="order-bank" border="0" cellpadding="0">
    <tbody>
    <tr>
        <td width="3%"></td>
        <td width="35%" style="border-top-width:1px; text-align: center; font-size:15pt; color: black">Holders Signature</td>
        <td width="5%" style="text-align: left; font-size:15pt;"></td>
        <td width="40%" style="border-top-width:1px; text-align: center; font-size:15pt; color: black">Authorized Signature</td>
        <td width="12%"></td>
    </tr>
    </tbody>

</table>
<div class="blank-space"></div>

{{--<div class="img-fluid" style="padding-left: -10px">--}}
    <img src="{!! public_path('cardphoto/frontfoot.png') !!}" width="515pt" height="70pt">
{{--</div>--}}


{{--<table class="order-bank" border="0" cellpadding="0">--}}
    {{--<tbody>--}}
    {{--<tr>--}}
        {{--<td width="90%" style="text-align: center;"><img src="{!! public_path('cardphoto/frontfoot.png') !!}" width="100%" height="40pt"></td>--}}
        {{--<td width="10%"></td>--}}
    {{--</tr>--}}
    {{--</tbody>--}}

{{--</table>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>