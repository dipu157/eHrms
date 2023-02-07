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

{{--<table border="0" cellpadding="0">--}}

    {{--<tr>--}}
        {{--<td width="33%"><img src="{!! public_path('/assets/images/Logobrb.png') !!}" style="width:250px;height:60px;"></td>--}}
        {{--<td width="2%"></td>--}}
        {{--<td width="60%" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br/> West Panthapath, Dhaka-1215</span></td>--}}

    {{--</tr>--}}
    {{--<tr>--}}
    {{--<td colspan="3"><span style="line-height: 60%; text-align:center; font-family:times;font-weight:bold;font-size:20pt;color:black;">77/A, East Rajabazar,West Panthapath, Dhaka-1215</span></td>--}}
    {{--</tr>--}}
    {{--<hr style="height: 2px">--}}

{{--</table>--}}


<table class="table order-bank" width="90%" cellpadding="2">
    <tbody>

    <tr>
        <td width="60%" style="font-size:10pt; text-align: left">Dated: {!! \Carbon\Carbon::now()->format('d-M-Y') !!}<br/>
        </td>
    </tr>

    <tr>
        <td width="60%" style="font-size:10pt; text-align: left">To <br/>
            <span style="font-weight: bold">The Branch Manager,</span> <br/>
            {!! $bank->name !!}<br/>
            {!! $bank->branch_name !!}<br/>
        </td>
    </tr>

    <tr>
        <td width="80%" style="font-size:10pt; text-align: left"><span style="font-weight: bold">Subject: Transfer of Tk. {!! number_format($bonus->sum('bonus.net_bonus'),2) !!}/= to respective <span >{!! $bank->id == 4 ? 'SND' :  'SB'   !!}</span> Account holders.</span> <br/>
        </td>
    </tr>

    <tr>
        <td width="100%" style="font-size:10pt; text-align: left">Dear Sir,<br/>You are requested to transfer the following listed amount to BRB Hospitals Ltd.'s employees respective  <span >{!! $bank->id == 4 ? 'SND' :  'SB'   !!}</span> Accounts as Bonus for Eid ul Adha {!! $period->calender_year !!} from our <span style="font-weight: bold">{!! $bank->id == 1 ? 'STD A/C.# 0021220004315' : $bank->id == 2 ? 'STD A/C.# 255120879' : ( $bank->id == 3 ? 'STD A/C.# 0011-0320001508':'A/C.# 3781102000819' ) !!}</span>  maintained with your Branch.
        </td>
    </tr>

    <div class="blank-space"></div>


    @if(!empty($bonus))

        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>
<tr class="row-line">
                <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="150px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
                <th width="80px" style="text-align: right; font-size: 10px; font-weight: bold">Bonus <br/>Amount</th>
                <th width="40px" style="text-align: right; font-size: 10px; font-weight: bold">Bank</th>
                <th width="90px" style="text-align: right; font-size: 10px; font-weight: bold">Account No</th>
                @if($bank->id == 3)
                <th width="90px" style="text-align: right; font-size: 10px; font-weight: bold">Tcs Account </th>
                @endif
                {{--<th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">Working <br/>Status</th>--}}
            </tr>
            </thead>
            <tbody>
            @php($sl = 1)

            {{--@foreach($employees->chunk(100) as $item)--}}
            @foreach($bonus as $row)

                    <tr>
                        <td width="25px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
                        <td width="150px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->personal->full_name !!}</td>
                        <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! number_format($row->bonus->net_bonus ?? 0,0) !!}</td>
                        <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! $bank->id == 1 ? 'AIBL' : $bank->id == 2 ? 'DBBL' : ( $bank->id == 3 ? 'JBL':'PBL' ) !!}</td>
                        <td width="90px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! $row->bonus->account_no ?? '' !!} </td>
                        @if($bank->id == 3)
                        <td width="90px" style="border-bottom-width:1px; font-size:8pt; text-align: right">{!! $row->bonus->tcs_account_no ?? '' !!} </td>
                        @endif
                        {{--                        <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->working_status_id !!}</td>--}}
                    </tr>
                    @php($sl++)
            @endforeach
            {{--@endforeach--}}
            </tbody>
            <div class="blank-space"></div>
            <tfoot>
                <tr>
                    <td colspan="4" style="border-bottom-width:1px; font-size:8pt; text-align: left; font-weight: bold">Total</td>
                    <td style="border-bottom-width:1px; font-size:8pt; text-align: right; font-weight: bold">{!! number_format($bonus->sum('bonus.net_bonus'),2) !!}</td>
                </tr>

                <tr>
                    <td style="border-bottom-width:1px; font-size:8pt; text-align: left; font-weight: bold">In Words</td>
                    <td colspan="4" style="border-bottom-width:1px; font-size:8pt; text-align: right; font-weight: bold">{!! convert_number_to_words($bonus->sum('bonus.net_bonus')) !!} Taka Only</td>
                </tr>

            </tfoot>
        </table>
        <div class="blank-space"></div>
    @endif

    <div class="blank-space"></div>

    <tr>

        <td width="80%" style="font-size:10pt; text-align: left">Thanking You <br/>
            With Best Regards,<br/>
            BRB Hospitals Limited

        </td>
    </tr>

    <div class="blank-space"></div>
    <div class="blank-space"></div>

    <tr>

        <td width="80%" style="font-size:12pt; text-align: left; font-weight: bold">Md. Mozibar Rahman, Chairman<br/>

        </td>
    </tr>

    </tbody>
</table>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

