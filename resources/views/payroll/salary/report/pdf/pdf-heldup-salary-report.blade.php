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

<table class="table order-bank" width="90%" cellpadding="2">
    <tbody>

    <tr>
        <td width="100%" style="font-size:20pt; text-align: left">Heldup Employee of {!! $period->month_name !!} -{!! $period->calender_year !!}
        </td>
    </tr>

    <div class="blank-space"></div>


    @if(!empty($data))

        <table class="table order-bank" width="100%" cellpadding="2">

            <thead>

            <tr class="row-line">
                <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">PF No</th>
                <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Employee ID</th>
                <th width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
                <th width="110px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
                <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">DOJ</th>
                <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">Reason</th>
            </tr>
            </thead>
            <tbody>
            @php($sl = 1)

            @foreach($data as $row)

                    <tr>
                        <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
                        <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->pf_no !!}</td>
                        <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                        <td width="120px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!}</td>
                        <td width="110px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation->name !!}</td>                      
                        <td width="70px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->joining_date !!}</td>                       
                        <td width="70px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->salary->heldup->reason !!}</td>                       
                    </tr>
                    @php($sl++)
            @endforeach
            {{--@endforeach--}}
            </tbody>

        </table>
        <div class="blank-space"></div>
    @endif

    <div class="blank-space"></div>

    </tbody>
</table>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

