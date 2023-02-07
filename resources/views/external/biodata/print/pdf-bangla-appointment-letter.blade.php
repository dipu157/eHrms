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

        body {
    font-family: 'bangla','kalpurush', sans-serif;
        }

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

        body {
            font-family: 'examplefont', sans-serif;
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

        <div>
            <table style="width:100%">
                <tr>
                    <td>
                        {{ $data->name }} <br>
                        {{ $data->fathers_name }} <br>
                        {{ $data->mothers_name }} <br>
                        {{ $data->present_address }} <br>
                        {{ $data->permanent_address }} <br>
                        {{ $data->submission_date }} <br>
                        {{ $data->designation->name }} <br>
                        {{ $data->department->name }} <br>
                        {{ $data->salary_grade }} <br>
                        {{ $data->provision_salary }} <br>
                        {{ $data->regular_salary }} <br>
                        {{ $data->responsibility }} <br>
                        {{ $data->provision_period }} <br>
                        {{ $data->joining_date }}
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <table class="table" style="width: 90%">
                <tr>
                    <td>বি আর বি হসঃ-  </td>
                    <td>তারিখঃ </td>
                </tr>
            </table>
        </div>
    @endif

<div class="blank-space"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

