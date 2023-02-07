
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

<div>
    <table style="width:100%">
        <tr>
            <td style="width:5%"></td>
            <td style="width:90%">
                <table style="width:100%" class="order-bank">
                    <thead>
                    <tr>
        <td width="100%" style="font-size:14pt; text-align: center">Overtime Salary {!! $period->month_name !!} -{!! $period->calender_year !!}
        </td>
    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>
<span  width="100%" style="font-size:12pt; text-align: right">All Department Wise Total Overtime</span>
    

    <div class="blank-space"></div>

    @if(!empty($salaries))
        @php($grandtotal = 0)

                <div class="card">
                    
                    
                <div class="blank-space"></div>
                  

                    <table class="table order-bank"  width="90%" cellpadding="2">

                            <thead>
                            <tr  class="row-line">
                        <th width="40px" style="font-size: 12px; font-weight: bold; text-align: center">SL</th>
                        <th width="150px" style="font-size: 12px; font-weight: bold; text-align: center">Department Name</th>
                        <th width="80px" style="font-size: 12px; font-weight: bold; text-align: center">OT Emp </th>
                        <th width="80px" style="font-size: 12px; font-weight: bold; text-align: center">OT Hours</th>
                        <th width="80px" style="font-size: 12px; font-weight: bold; text-align: center">OT Amount</th>
                       
                    </tr>
   
                            </thead>

                            <tbody>
                            @php($count = 1)
    @php($grand_total_hr = 0)
    @php($grand_total_am = 0)
    @php($grand_total_emp = 0)
   
    @foreach ($dept_sum as $sub => $amounts)

        <tr class="row-border">
            @foreach ($amounts as $row)

                @php($dname = $departments->where('department_id',$sub)->first())

                <td width="40px" style="border-bottom-width:1px; font-size:10pt; text-align:                 <td width="250px" style="border-bottom-width:1px; font-size:10pt; text-align: center">{!! $dname->department->name !!}</td>
">{!! $count !!}</td>
                <td width="150px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $dname->department->name !!}</td>
                
                <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! number_format($row->employee_count,0)  !!}</td>
                <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! number_format($row->overtime_hour,0)  !!}</td>
                <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! number_format($row->overtime_amount,0)  !!}</td>

                @php($count++)

            @endforeach
        </tr>
        @php($grand_total_hr = $grand_total_hr + $row->overtime_hour ?? 0)
                            @php($grand_total_am = $grand_total_am + $row->overtime_amount ?? 0)
                            @php($grand_total_emp = $grand_total_emp + $row->employee_count ?? 0)  
    @endforeach
                           
                              
                            </tbody>

                            <tfoot>
                            <div class="blank-space"></div>
                            <tr style="background-color:#696969" >
                    <td ></td>
                        <td style="text-align: center; font-size: 10px; font-weight: bold">All Department Grand Total</td>
                        <td style="font-size: 10px; font-weight: bold; text-align: center"></td>
                        <td style="font-size: 10px; font-weight: bold; text-align: center">{!! $grand_total_hr !!}  Hours</td>
                        <td style="font-size: 10px; font-weight: bold; text-align: center">{!! $grand_total_am !!}  Tk</td>


                       
                    </tr>
                                    
                            </tfoot>
                        </table>
                   
                </div>            
        @endif
        


<div class="blank-space"></div>
<div class="blank-space"></div>
<div class="blank-space"></div>

<table class="table order-bank" width="90%" cellpadding="2">

    <thead>
    {{--<tr>--}}
    {{--<th width="25%" style="text-align: left; font-size: 8px; font-weight: bold">-</th>--}}
    {{--<th width="25%" style="text-align: left; font-size: 8px; font-weight: bold">-</th>--}}
    {{--<th width="25%" style="text-align: left; font-size: 8px; font-weight: bold">-</th>--}}
    {{--<th width="25%" style="text-align: center; font-size: 8px; font-weight: bold">-</th>--}}
    {{--</tr>--}}
    
    </thead>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

