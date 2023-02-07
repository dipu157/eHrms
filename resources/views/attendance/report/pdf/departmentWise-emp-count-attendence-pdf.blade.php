<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">


    <style>
        table.table {
            width: 100%;
            margin: 0;
            background-color: #ffffff;
        }

        table.order-bank {
            width: 100%;
            margin: 0;
        }

        table.order-bank th {
            padding: 5px;
        }

        table.order-bank td {
            padding: 5px;
            background-color: #ffffff;
        }

        tr.row-line th {
            border-bottom-width: 1px;
            border-top-width: 1px;
            border-right-width: 1px;
            border-left-width: 1px;
        }

        tr.row-line td {
            border-bottom: none;
            border-bottom-width: 1px;
            font-size: 10pt;
            border-bottom-width: 1px;
            border-top-width: 1px;
            border-right-width: 1px;
            border-left-width: 1px;
        }

        th.first-cell {
            text-align: left;
            border: 1px solid red;
            color: blue;
        }

        div.order-field {
            width: 100%;
            background: #ffdab9;
            border-bottom: 1px dashed black;
            color: black;
        }

        div.blank-space {
            width: 100%;
            height: 50%;
            margin-bottom: 100px;
            line-height: 10%;
        }

        div.blank-hspace {
            width: 100%;
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
            <td width="60%" style="text-align: right"><span
                    style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A,
                    East Rajabazar, <br /> West Panthapath, Dhaka-1215</span></td>

        </tr>
        <hr style="height: 2px; margin-bottom: 30px;">

    </table>

    <div class="blank-space"></div>
    <span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; padding-top: 10px; ">
        Department Wise Total Employees as on  {!! \Carbon\Carbon::parse($report_date)->format('d-M-Y') !!}<br />
    </span>


    <div class="blank-space"></div>


    <div>
        @if (!empty($data))
            <table class="table order-bank" width="90%" cellpadding="2">

                <thead>
                    <tr class="row-line">
                        <th width="40px" style="font-family:times; font-size: 11px; font-weight: bold; text-align: center">SL</th>
                        <th width="220px" style="font-family:times; font-size: 11px; font-weight: bold; text-align: center">Department
                            Name</th>
                        <th width="100px" style="font-family:times; font-size: 11px; font-weight: bold; text-align: center">Total Employee
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $row)
                        <tr class="row-line">
                            <td width="40px" style="text-align: center; font-size: 10px;">{!! $i + 1 !!}</td>
                            <td width="220px" style="font-family:times;font-size: 10px; text-align: left">
                                {!! $row->department->name !!}
                            </td>
                            <td width="100px" style="text-align: center">
                                {!! $row->emp_count !!}
                            </td>
                        </tr>

                        {{-- @php($t_emp = $t_emp+) --}}
                    @endforeach
                </tbody>
                <br>
                <tfoot>
                    <tr style="background-color:#696969">
                        <td></td>
                        <td style="text-align: center; font-size: 12px; font-weight: bold">Total</td>
                        <td style="font-size: 12px; font-weight: bold; text-align: center">{!! $data->sum('emp_count') !!}</td>



                    </tr>
                </tfoot>
            </table>

        @endif
        <div>



            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
            {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
            <script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>

</html>
