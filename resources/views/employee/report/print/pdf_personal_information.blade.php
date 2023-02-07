<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <link href="{!! asset('assets/bootstrap-4.1.3/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    {{--<link rel="stylesheet" type="text/css" href="src/common/css/bootstrap.min.css" />--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script type="text/javascript" src="src/common/js/bootstrap.min.js"></script>--}}


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
            font-size: 10pt;
        }

        th.first-cell {
            text-align: left;
            border: 1px solid red;
            color: blue;
        }

        div.order-field {
            width: 100%;
            backgroundr: #ffdab9;
            border-bottom: 1px dashed black;
            color: black;
        }

        div.blank-space {
            width: 100%;
            height: 50%;
            margin-bottom: 80px;
            line-height: 10%;
        }

        div.blank-hspace {
            width: 100%;
            height: 25%;
            margin-bottom: 50px;
            line-height: 10%;
        }

        table.foot-tab{
            border-bottom-width: 1px;
            border-top-width: 1px;
            border-right-width: 1px;
            border-left-width: 1px;

        }
    </style>

</head>

<body>
    <div class="blank-space"></div>

 @php

    $gtotal_leaveAvailed = $total_wHolidays + $total_gHolidays + $data->absent + $emp_yearly_leave[0]->leave_enjoyed + $emp_yearly_leave[1]->leave_enjoyed + $emp_yearly_leave[3]->leave_enjoyed + $emp_yearly_leave[4]->leave_enjoyed + $emp_yearly_leave[5]->leave_enjoyed + $emp_yearly_leave[6]->leave_enjoyed + $emp_yearly_leave[7]->leave_enjoyed + $emp_yearly_leave[8]->leave_enjoyed + $emp_yearly_leave[9]->leave_enjoyed ;

    $total_leaveAvailed = $data->absent + $emp_yearly_leave[0]->leave_enjoyed + $emp_yearly_leave[1]->leave_enjoyed + $emp_yearly_leave[3]->leave_enjoyed + $emp_yearly_leave[4]->leave_enjoyed + $emp_yearly_leave[5]->leave_enjoyed + $emp_yearly_leave[6]->leave_enjoyed + $emp_yearly_leave[7]->leave_enjoyed + $emp_yearly_leave[8]->leave_enjoyed + $emp_yearly_leave[9]->leave_enjoyed ;


$total_Lwp = $data->absent + $emp_yearly_leave[8]->leave_enjoyed;
    $present = $total_wDays - $gtotal_leaveAvailed;

    $leave_earned = (int)($present/18);

    $next_year_leave = ($emp_yearly_leave[3]->leave_balance) + $leave_earned;

    if($next_year_leave > 60){

    $next_year_leave_deduct = $next_year_leave - 60;

    $next_year_leave_final = 60;
    }else {
        $next_year_leave_deduct = 0;

        $next_year_leave_final = $leave_earned;
    }   


    @endphp


    <table border="0" cellpadding="0">

        <tr>
            <td width="33%"><img src="{!! public_path('/assets/images/Logobrb.png') !!}" style="width:250px;height:50px;"></td>
            <td width="2%"></td>
            <td width="50%" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br /> West Panthapath, Dhaka-1215</span></td>

        </tr>


        <hr style="height: 2px">


    </table>

    <div class="blank-space"></div>

    <div>
        <table style="width:100%">
            <tr>
                <td style="width:10%"></td>
                <td style="width:90%">
                    <table style="width:100%" class="order-bank">
                        <thead>
                            <tr>

                                <td style="width:75%;"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14px;color:#000000; ">
                                       <u> <h3>Personal Information </h3></u>
                                    </span></td>

                                <td style="width:25% padding-top:11px;"><span style="text-align:right; font-family:times;font-weight:bold;font-size:12pt; ">
                                     PF No: {{ $employees->pf_no }}
                                    </span></td>

                                
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="width:5%"></td>
            </tr>
        </table>
    </div>

    
    <table class="table order-bank" width="95%" style="font-size: 9px;">

        <tr>
            <td width="5%">01</td>
            <td width="15%" >Employee ID</td>
            <td>: {{ $employees->employee_id }}</td>
        </tr>

        <tr>
            <td width="5%">02</td>
            <td width="15%">Name</td>
            <td>:<b>{{ $employees->personal->full_name }}</b></td>
        </tr>

        <tr>
            <td width="5%">03</td>
            <td width="15%">Father's Name</td>
            <td>: {{ $employees->personal->father_name }} </td>
        </tr>

        <tr>
        <td width="5%">04</td>
            <td width="15%">Mother's Name</td>
            <td>: {{ $employees->personal->mother_name }}</td>
        </tr>
        <tr>
        <td width="5%">05</td>
            <td width="15%">Address</td>
            <td>: {{ $employees->personal->pr_address }}</td>
        </tr>
        <tr>
        <td width="5%">06</td>
            <td width="15%">Qualification</td>
            <td>: {{ $employees->personal->last_education }}</td>
        </tr>
    
        <tr>
        <td width="5%">07</td>
        <td width="15%">Date of Birth</td>
            <td>:{!! \Carbon\Carbon::parse($employees->personal->dob)->format('d-M-Y') !!}</td>
        </tr>

        <tr>
        <td width="5%">08</td>
        <td width="15%">National ID No</td>
            <td>: {{ $employees->personal->national_id }}</td>
        </tr>

        <tr>
        <td width="5%">09</td>
        <td width="15%">Blood Group</td>
            <td>: {{ $employees->personal->blood_group }}</td>
        </tr>
        <tr>
        <td width="5%">10</td>
        <td width="15%">Joining Date</td>
            <td width="50%">: <span>{!! \Carbon\Carbon::parse($employees->joining_date)->format('d-M-Y') !!} </span>

            <span style="font-weight: bold;"> {!! "(" . \Carbon\Carbon::parse($employees->joining_date)->diff(\Carbon\Carbon::parse($end))->format('%y years, %m months, %d days') . " )" !!}</span></td>
        </tr>
      
        <tr>
        <td width="5%">11</td>
        <td width="15%">Confirmation Date</td>
            <td>:  </td>
        </tr>


        <tr>
        <td width="5%">12</td>
        <td width="15%">Service history</td>
        <td>: <table class="table order-bank" width="90%" cellpadding="2">

<thead>

<tr class="row-line">

    <th rowspan="2" width="40px" style="text-align: center; font-size: 06px; font-weight: bold">Fixation Date</th>

    <th colspan="2" scope="colgroup" width="70px" style="text-align: center; font-size: 06px; font-weight: bold">Working</th>
    <th rowspan="2" width="58px" style="text-align: center; font-size: 06px; font-weight: bold">Designation</th>
    <th rowspan="2" width="30px" style="text-align: center; font-size: 06px; font-weight: bold">Scale</th>
    <th rowspan="2" width="32px" style="text-align: center; font-size: 06px; font-weight: bold">Basic<br/>salary</th>
    <th rowspan="2" width="32px" style="text-align: center; font-size: 06px; font-weight: bold">House<br/>Rent</th>
    <th rowspan="2" width="30px" style="text-align: center; font-size: 06px; font-weight: bold">Medical</th>
    <th rowspan="2" width="35px" style="text-align: center; font-size: 06px; font-weight: bold">Convince</th>
    <th rowspan="2" width="30px" style="text-align: center; font-size: 06px; font-weight: bold">Entertainment</th>
    <th rowspan="2" width="30px" style="text-align: center; font-size: 06px; font-weight: bold">Other Allow</th>
    <th rowspan="2" width="40px" style="text-align: center; font-size: 06px; font-weight: bold">Salary</th>
</tr>

<tr class="row-line">
    <th width="30px" style="text-align: center; font-size: 06px; font-weight: bold">Place</th>
    <th width="40px" style="text-align: center; font-size: 06px; font-weight: bold">Dept</th>
</tr>
</thead>


<tbody>


    <tr style="line-height: 250%">
        <td width="40px" style=" border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">6/3/21</td>
        <td width="30px" style=" border-bottom-width:1px; font-size:6pt; text-align: center">Hospital</td>
        <td width="40px" style=" border-bottom-width:1px; font-size:6pt; text-align: center">{!! $employees->department->short_name !!}</td>
        <td width="58px" style=" border-bottom-width:1px; font-size:6pt; text-align: center">{!! $employees->designation->short_name !!}</td>
        <td width="30px" style="border-bottom-width:1px; font-size:6pt; text-align: center"></td>
        <td width="32px" style="border-bottom-width:1px; font-size:6pt; text-align: center">{!! $employees->salary_properties->basic !!}</td>
        <td width="32px" style="border-bottom-width:1px; font-size:6pt; text-align: center">{!!  $employees->salary_properties->house_rent !!}</td>
        <td width="30px" style="border-bottom-width:1px; font-size:6pt; text-align: center">{!!  $employees->salary_properties->medical !!}</td>
        <td width="35px" style="border-bottom-width:1px; font-size:6pt; text-align: center">{!!  $employees->salary_properties->conveyance !!}</td>
        <td width="30px" style="border-bottom-width:1px; font-size:6pt; text-align: center">{!!  $employees->salary_properties->entertainment !!}</td>
        <td width="30px" style="border-bottom-width:1px; font-size:6pt; text-align: center">{!!  $employees->salary_properties->other_allowance !!}</td>
        <td width="40px" style="border-bottom-width:1px; border-right-width:1px; font-size:6pt; text-align: center">{!!  $employees->salary_properties->gross_salary  !!}</td>
               
     
    </tr>

</tbody>
</table> </td>
        </tr>

        <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
      
        <tr>
        <td width="5%">13</td>
        <td width="15%">Leave History</td>
            <td>: <table class="table order-bank" width="90%" cellpadding="2">

<thead>

<tr class="row-line">

    <th rowspan="2" width="20px" style="text-align: center; font-size: 06px; font-weight: bold">year</th>
    <th colspan="10" scope="colgroup" width="200px" style="text-align: center; font-size: 06px; font-weight: bold">Total Leave Enjoyed</th>
    <th rowspan="2" width="30px" style="text-align: center; font-size: 06px; font-weight: bold">Working <br/> day</th>
    <th rowspan="2" width="28px" style="text-align: center; font-size: 06px; font-weight: bold">Present<br/> day</th>
    <th rowspan="2" width="28px" style="text-align: center; font-size: 06px; font-weight: bold">All<br/>Reserve</th>
    <th rowspan="2" width="35px" style="text-align: center; font-size: 06px; font-weight: bold">All<br/>Obtained</th>
    <th rowspan="2" width="25px" style="text-align: center; font-size: 06px; font-weight: bold">Total Al</th>
    <th rowspan="2" width="26px" style="text-align: center; font-size: 06px; font-weight: bold">Leave<br/>Cancel</th>
    <th rowspan="2" width="35px" style="text-align: center; font-size: 06px; font-weight: bold">Reserved</th>
   
</tr>

<tr class="row-line">

    <th width="15px" style="text-align: center; font-size: 06px; font-weight: bold">AL</th>
    <th width="15px" style="text-align: center; font-size: 06px; font-weight: bold">CL</th>
    <th width="15px" style="text-align: center; font-size: 06px; font-weight: bold">SL</th>
    <th width="20px" style="text-align: center; font-size: 06px; font-weight: bold">Lwp</th>
    <th width="20px" style="text-align: center; font-size: 06px; font-weight: bold">SPL</th>
    <th width="15px" style="text-align: center; font-size: 06px; font-weight: bold">QL</th>
    <th width="15px" style="text-align: center; font-size: 06px; font-weight: bold">ML</th>
    <th width="20px" style="text-align: center; font-size: 06px; font-weight: bold">Total</th>
    <th width="20px" style="text-align: center; font-size: 06px; font-weight: bold">W/H </th>
    <th width="20px" style="text-align: center; font-size: 06px; font-weight: bold">F/H </th>
    <th width="25px" style="text-align: center; font-size: 06px; font-weight: bold">TLA </th>
</tr>
</thead>
<tbody>


    <tr style="line-height: 250%">
        <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">2021</td>
        <td width="15px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $emp_yearly_leave[3]->leave_enjoyed !!}</td>
        <td width="15px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $emp_yearly_leave[0]->leave_enjoyed !!}</td>
        <td width="15px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $emp_yearly_leave[1]->leave_enjoyed !!}</td>
        <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $total_Lwp !!}</td>
        <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $emp_yearly_leave[7]->leave_enjoyed !!}</td>
        <td width="15px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $emp_yearly_leave[5]->leave_enjoyed !!}</td>
        <td width="15px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $emp_yearly_leave[4]->leave_enjoyed !!}</td>
        <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $total_leaveAvailed !!}</td>
        <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $total_wHolidays !!}</td>
        <td width="20px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $total_gHolidays !!}</td>
        <td width="25px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $gtotal_leaveAvailed !!}</td>


        <td width="30px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $total_wDays !!}</td>
        <td width="28px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $present !!}</td>
        <td width="28px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! ($emp_yearly_leave[3]->leave_balance) !!}</td>
        <td width="35px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $leave_earned !!}</td>
        <td width="25px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $next_year_leave !!}</td>
        <td width="26px" style="border-bottom-width:1px; border-left-width:1px; font-size:6pt; text-align: center">{!! $next_year_leave_deduct !!}</td>
        <td width="35px" style="border-bottom-width:1px; border-left-width:1px; border-right-width:1px; font-size:6pt; text-align: center">{!! $next_year_leave - $next_year_leave_deduct !!}</td>
    </tr>

</tbody>
</table> 
</td>
        
        </tr>

        </table>

    <div class="blank-space"></div>
    <div class="blank-space"></div>

    <table class="table order-bank" width="90%">
            <tr style="text-align: left; font-size: 10px;">
                <td width="5%">14</td>
                <td style="font-size: 9pt;" width="17%">Suspention &nbsp;&nbsp;&nbsp;&nbsp; :</td>
                <td style="border-bottom-width:1px; text-align: center; font-size:8pt;" width="78%">
                    @foreach($punish as $p)
                    @if($p->punish_id == 1)
                    <span>
                        {!! \Carbon\Carbon::parse($p->effective_date)->format('d-M-Y') !!}       
                    </span>
                    @endif
                    @endforeach 
                </td>    
            </tr>

            <tr style="text-align: left; font-size: 10px;">
                <td width="5%">15</td>
                <td style="font-size: 9pt;" width="17%">Show Causes :</td>
                <td style="border-bottom-width:1px; text-align: center; font-size:8pt;" width="78%">
                    @foreach($punish as $p)
                    @if($p->punish_id == 2)
                    <span>
                        {!! \Carbon\Carbon::parse($p->effective_date)->format('d-M-Y') !!}       
                    </span>
                    @endif
                    @endforeach 
                </td>   
            </tr>

            <tr style="text-align: left; font-size: 10px;">
                <td width="5%">16</td>
                <td style="font-size: 9pt;" width="17%">Warning &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
                <td style="border-bottom-width:1px; text-align: center; font-size:8pt;" width="78%">
                   @foreach($punish as $p)
                    @if($p->punish_id == 3)
                    <span>
                        {!! \Carbon\Carbon::parse($p->effective_date)->format('d-M-Y') !!}       
                    </span>
                    @endif
                    @endforeach 
                </td>  
            </tr>

            <tr style="text-align: left; font-size: 10px;">
                <td width="5%">17</td>
                <td style="font-size: 9pt;" width="17%">Miscellanceous :</td>
                <td style="border-bottom-width:1px; text-align: center; font-size:8pt;" width="78%">
                     @foreach($punish as $p)
                    @if($p->punish_id == 4)
                    <span>
                        {!! \Carbon\Carbon::parse($p->effective_date)->format('d-M-Y') !!}       
                    </span>
                    @else
                    @endif
                    @endforeach 
                </td> 
            </tr>
        
    </table>
      
    
    <div class="blank-space"></div>
    <div class="blank-space"></div>

<table class="table order-bank" width="90%" cellpadding="2">

    <thead>
    <tr>
        <th width="10%" style="text-align: left; font-size: 10px; font-weight: bold"></th>
        <th width="35%" style="text-align: left; font-size: 9px; font-weight: bold"></th>
        <th width="10%" style="text-align: left; font-size: 12px; font-weight: bold"></th>
        <th width="35%" style="text-align: right; font-size: 9px; font-weight: bold">CEO</th>
    </tr>
    </thead>
</table>

<div class="blank-space"></div>

<table class="foot-tab" width="100%">

    <tr><td></td></tr>

    <tr>
        <td width="50%" style="text-align: left; font-size: 9px; padding-left: 10px;">Yearly Increment: </td>
        <td width="50%" style="text-align: right; font-size: 9px; padding-right: 10px;">Approved/ Not Approved </td>
    </tr>

    <tr><td></td></tr>

    <tr> 
        <td style="text-align: left; font-size: 10px; margin-top: 30px;">Comments:</td>
    </tr>

    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>
    <div class="blank-space"></div>

    <tr> 
        <td width="10%"></td>
        <td width="30%" style="text-align: left; font-size: 7px;">DGM(Finance)<br>BRB Cable Ind. Ltd.</td>
        <td width="30%" style="text-align: center; font-size: 7px; padding-left: 50px;">DGM(Finance)<br>BRB Hospitals Ltd.</td>
        <td width="30%" style="text-align: right; font-size: 7px;">GM(Admin)<br>BRB Cable Ind. Ltd.</td>
    </tr>

</table>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>

</html>