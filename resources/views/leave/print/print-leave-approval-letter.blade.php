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

<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>

    <table class="table order-bank" width="90%" cellpadding="2">
        <tbody>

        <tr>
            <td width="60%" style="font-size:10pt; text-align: left">Dated: {!! \Carbon\Carbon::now()->format('d-M-Y') !!}<br/>
            </td>
        </tr>
        <div class="blank-space"></div>

        <tr>
            <td width="60%" style="font-size:10pt; text-align: left">To <br/>
                <span style="font-weight: bold">{!! $leave->personal->full_name !!}</span> <br/>
                {!! $leave->professional->designation->name !!}<br/>
                {!! $leave->personal->professional->department->name !!}<br/>
                BRB Hospitals Ltd<br/>
                Panthapath, Dhaka -1215

            </td>
        </tr>
        <div class="blank-space"></div>
        <div class="blank-space"></div>
        <tr>
            <td width="100%" style="font-size:10pt; text-align: left">Dear Applicant,<br/>Respond to your application submitted on {!! \Carbon\Carbon::parse($leave->created_at)->format('d-M-Y') !!},
                the management has <strong>{!! $leave->status === 'A' ? 'Approved' : 'Rejected' !!}</strong> your {!! $leave->nods !!} {!! $leave->nods > 1 ? 'days ' : 'day ' !!}  {!! $leave->type->name !!} from
                {!! \Carbon\Carbon::parse($leave->from_date)->format('d-M-Y') !!} to {!! \Carbon\Carbon::parse($leave->to_date)->format('d-M-Y') !!} and you are {!! $leave->status === 'A' ? 'permitted' : 'Not permitted' !!}
                to leave the office for mentioned {!! $leave->nods > 1 ? 'days' : 'day' !!} only.
            </td>
        </tr>

        <div class="blank-space"></div>
        <div class="blank-space"></div>
        <div class="blank-space"></div>
        <div class="blank-space"></div>

        <tr>
            <td width="2%"></td>
            {{-- <td width="20%"><img src="{!! public_path('/sign/2192022.png') !!}" style="width:50px;height:30px;"></td> --}}
        </tr>

        <tr>

            <td width="20%" style="border-top-width: 1px; font-size:10pt; text-align: left">

               Dr.Md.Monsur Ali
               Director-Medical Services &
               CEO (Additional)
               BRB Hospitals Limited
            </td>
        </tr>

        </tbody>
    </table>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

