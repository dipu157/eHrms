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
            margin: 0px;
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
            border-top-width:2px;
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
            background : #ffdab9;
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

<table border="0" cellpadding="0">

    <tr>
        <td style="width:90%;"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:20pt;color:#000000; ">BRB Hospitals Limited</span>
        <span style="text-align: center; font-size: 15px;"><br>

            <span style="font-family:times; height: 100%; font-size:13pt;color:black;"><u>77/A, East Rajabazar, West Panthapath, Dhaka-1215</u></span><br>

            @if(!empty($dept_name))

            <span style="font-family:times; height: 100%;font-weight:bold; font-size:17pt;color:black;">Department : {{ $dept_name[0] }}</span>

            @endif
        </span>

        </td>
                        
    </tr>


</table>


    @if(!empty($employees))
    @foreach($departments as $i=>$dept)

    @if($employees->contains('department_id',$dept->id))

        <div style="text-align: left; font-size: 10px; font-weight: bold"></div>

                    <table class="table order-bank" width="100%" cellpadding="2">

                        <thead>
                            @if(empty($dept_name))
                        <tr>                            
                            <th style="text-align: left; font-size: 10px; font-weight: bold">Department : {!! $dept->name !!}</th>
                            
                        </tr>
                        @endif
                        
                        <tr class="row-line">
                            <th rowspan="2" width="25px" style="text-align: center; font-size: 11px; font-weight: bold">SL</th>
                            <th rowspan="2" width="80px" style="text-align: center; font-size: 11px; font-weight: bold">PF No/ID No.</th>
                            <th rowspan="2" width="120px" style="text-align: center; font-size: 11px; font-weight: bold">Name</th>
                            <th rowspan="2" width="80px" style="text-align: center; font-size: 11px; font-weight: bold">Home <br>District</th>
                            <th rowspan="2" width="110px" style="text-align: center; font-size: 11px; font-weight: bold">Qualification</th>
                            <th rowspan="2" width="80px" style="text-align: center; font-size: 11px; font-weight: bold">DOB</th>

                            <th colspan="6" scope="colgroup" width="265px" style="text-align: center; font-size: 11px; font-weight: bold">Joining</th>

                            <th colspan="6" scope="colgroup" width="265px" style="text-align: center; font-size: 11px; font-weight: bold">Present</th>

                            
                            <th rowspan="2" width="65px" style="text-align: center; font-size: 11px; font-weight: bold">Remarks</th>
                        </tr>

                        <tr class="row-line">

                            <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">Date</th>
                            <th width="125px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
                            <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">Salary</th>

                            <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">Date</th>
                            <th width="125px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
                            <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">Salary</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php($sl = 1)

                        @foreach($employees as $row)
                        @if($dept->id == $row->department_id)
                
                                <tr class="row-border">

                                            <td width="25px" style="font-size:10pt; text-align: left">{!! $sl !!}</td>
                                            <td width="80px" style="font-size:10pt; text-align: left">{!! $row->pf_no !!} / {!! $row->employee_id !!}</td>
                                            <td width="120px" style="font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>
                                            <td width="80px" style="font-size:10pt; text-align: left">{!! $row->personal->pm_district !!}</td>
                                            <td width="110px" style="font-size:10pt; text-align: left">{!! $row->personal->last_education !!}</td>

                                            <td width="80px" style="font-size:10pt; text-align: left">{!! \Carbon\Carbon::parse($row->personal->dob)->format('d-M-Y') !!}</td>

                                            <td width="70px" style="font-size:10pt; text-align: right">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-M-Y') !!}</td>
                                            <td width="125px" style="font-size:10pt; text-align: right">{!! count($row->history) ? $row->history[0]->designation->name : "" !!}</td>

                                            <td width="70px" style="font-size:10pt; text-align: right">{!! count($row->history) ? $row->history[0]->gross_salary : ""  !!}</td>

                                            <td width="70px" style="font-size:10pt; text-align: right">{!! \Carbon\Carbon::parse($row->salary_properties->updated_at)->format('d-M-Y') !!}</td>
                                            <td width="125px" style="font-size:10pt; text-align: right">{!! $row->designation->name !!}</td>
                                            <td width="70px" style="font-size:10pt; text-align: right">{!! $row->salary_properties->gross_salary ? $row->salary_properties->gross_salary : $row->history[0]->gross_salary !!}</td>

                                           
                                            <td width="65px"></td>

                                </tr>

                                @php($sl++) 
                                @endif
                      
                                @endforeach
                        </tbody>

                    </table>
                    @endif


@endforeach
                    @endif


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

