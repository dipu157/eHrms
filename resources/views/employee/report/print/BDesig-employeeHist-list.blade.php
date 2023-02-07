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
            width: 100%;
            margin: 0px;
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
            border-top-width: 2px;
            border-right-width: 1px;
            border-left-width: 1px;
        }

        tr.row-line td {
            border-bottom: none;
            border-bottom-width: 1px;
            font-size: 10pt;
        }

        tr.row-border td {
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

    <table border="0" cellpadding="0">

        <tr>
            <td style="width:90%;"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:20pt;color:#000000; ">BRB Hospitals Limited</span>
                <span style="text-align: center; font-size: 15px;"><br>

                    <span style="font-family:times; height: 100%; font-size:13pt;color:black;"><u>77/A, East Rajabazar, West Panthapath, Dhaka-1215</u></span><br>

                    @if(!empty($Bdesig_name))

                    <span style="font-family:times; height: 100%;font-weight:bold; font-size:17pt;color:black;">Base Designation : {{ $Bdesig_name[0] }}</span>

                    @endif
                </span>

            </td>

        </tr>


    </table>


    @if(!empty($employees))
    @foreach($Bdesignation as $i=>$Bdesig)

    @if($employees->contains('base_designation_id',$Bdesig->id))

    <div style="text-align: left; font-size: 10px; font-weight: bold"></div>

    <table class="table order-bank" width="100%" cellpadding="2">

        <thead>
            @if(empty($Bdesig_name))
            <tr>
                <th style="text-align: left; font-size: 10px; font-weight: bold">Base Designation : {!! $Bdesig->name !!}</th>
            </tr>
            @endif

            <tr class="row-line">
                <th rowspan="2" width="20px" style="text-align: center; font-size: 9px; font-weight: bold">SL</th>
                <th rowspan="2" width="80px" style="text-align: center; font-size: 9px; font-weight: bold">PF No/ID No.</th>
                <th rowspan="2" width="80px" style="text-align: center; font-size: 9px; font-weight: bold">Name</th>
                <th colspan="4" width="100px" style="text-align: center; font-size: 9px; font-weight: bold">Date of Birth</th>

                <th rowspan="2" width="60px" style="text-align: center; font-size: 9px; font-weight: bold">Qualification</th>
                <th rowspan="2" width="70px" style="text-align: center; font-size: 9px; font-weight: bold">Date of <br /> Joining</th>
                <th colspan="6" scope="colgroup" width="75px" style="text-align: center; font-size: 9px; font-weight: bold">Service <br /> Length</th>

                <th colspan="6" scope="colgroup" width="190px" style="text-align: center; font-size: 9px; font-weight: bold">Joining & Subsequently <br /> Promoted</th>

                <th colspan="2" scope="colgroup" width="60px" style="text-align: center; font-size: 9px; font-weight: bold">Present Working <br /> Place </th>
                <th colspan="6" scope="colgroup" width="240px" style="text-align: center; font-size: 9px; font-weight: bold">Recommendation</th>

                <th rowspan="2" width="100px" style="text-align: center; font-size: 9px; font-weight: bold">Proposed Salary</th>

                <th rowspan="2" width="60px" style="text-align: center; font-size: 9px; font-weight: bold">Remarks</th>
            </tr>

            <tr class="row-line">

                <th width="70px" style="text-align: left; font-size: 10px; font-weight: bold">Date</th>
                <th width="30px" style="text-align: left; font-size: 10px; font-weight: bold">Age</th>

                <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">Y</th>
                <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">M</th>
                <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">D</th>

                <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Salary</th>
                <th width="65px" style="text-align: left; font-size: 10px; font-weight: bold">Date</th>

                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Location</th>

                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Promotion</th>
                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Change
                    <be /> Designation
                </th>
                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Additional Amount</th>
                <th width="60px" style="text-align: left; font-size: 10px; font-weight: bold">Fixation Amount </th>

            </tr>
        </thead>

        <tbody>

            @php($sl = 1)

            @foreach($employees as $row)
            @if($Bdesig->id == $row->base_designation_id)

            <tr class="row-border">

                <td width="20px" style="font-size:10pt; text-align: left">{!! $sl !!}</td>
                <td width="80px" style="font-size:10pt; text-align: left">{!! $row->pf_no !!} / {!! $row->employee_id !!}</td>
                <td width="80px" style="font-size:10pt; text-align: left">{!! $row->personal->full_name !!}</td>

                <td width="70px" style="font-size:10pt; text-align: left">{!! \Carbon\Carbon::parse($row->personal->dob)->format('d-M-Y') !!}</td>
                <td width="30px" style="font-size:10pt; text-align: left"> {{ \Carbon\Carbon::parse($row->personal->dob)->diff(\Carbon\Carbon::parse($enddate))->format('%y') }} </td>

                <td width="60px" style="font-size:10pt; text-align: left">{!! $row->personal->last_education !!}</td>
                <td width="70px" style="font-size:10pt; text-align: left">{!! \Carbon\Carbon::parse($row->joining_date)->format('d-M-Y') !!}</td>

                <td width="25px" style="font-size:10pt; text-align: right">{{ \Carbon\Carbon::parse($row->joining_date)->diff(\Carbon\Carbon::parse($enddate))->format('%y') }}</td>
                <td width="25px" style="font-size:10pt; text-align: right">{{ \Carbon\Carbon::parse($row->joining_date)->diff(\Carbon\Carbon::parse($enddate))->format('%m') }}</td>
                <td width="25px" style="font-size:10pt; text-align: right">{{ \Carbon\Carbon::parse($row->joining_date)->diff(\Carbon\Carbon::parse($enddate))->format('%d') }}</td>

                

                <td width="65px" style="font-size:10pt; text-align: right">
                @foreach($empHistory as $his)
                @if($row->employee_id == $his->employee_id)
                    {!! $his->designation->name !!}     <br/><br/>             
                @endif
                @endforeach
                Current Salary
                </td>
                <td width="60px" style="font-size:10pt; text-align: right">
                @foreach($empHistory as $his)
                @if($row->employee_id == $his->employee_id)
                    {!! $his->gross_salary ? $his->gross_salary : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                {!! $row->salary_properties->gross_salary ? $row->salary_properties->gross_salary : "" !!}
                </td>
                <td width="65px" style="font-size:10pt; text-align: right">
                @foreach($empHistory as $his)
                @if($row->employee_id == $his->employee_id)
                    {!! $his->effective_date ? 
                        \Carbon\Carbon::parse($his->effective_date)->format('d-M-Y') : 
                            \Carbon\Carbon::parse($row->joining_date)->format('d-M-Y') !!} <br/> <br/>   
                   
                @endif
                @endforeach
                {{ \Carbon\Carbon::parse($his->end_date)->format('d-M-Y') }}
                </td>
                

                <td width="60px" style="font-size:10pt; text-align: right">Hospital</td>

                <td width="60px" style="font-size:10pt; text-align: right">
                @foreach($empRecomend as $rec)
                @if($row->employee_id == $rec->employee_id)
                    {!! $rec->promotion_name ? $rec->promotion_name : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                </td>
                <td width="60px" style="font-size:10pt; text-align: right">
                @foreach($empRecomend as $rec)
                @if( $row->employee_id == $rec->employee_id)
                    {!! $rec->change_designame ? $rec->change_designame : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                </td>
                <td width="60px" style="font-size:10pt; text-align: right">
                @foreach($empRecomend as $rec)
                @if($row->employee_id == $rec->employee_id)
                    {!! $rec->aditional_amt ? $rec->aditional_amt : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                </td>
                <td width="60px" style="font-size:10pt; text-align: right">
                @foreach($empRecomend as $rec)
                @if($row->employee_id == $rec->employee_id)
                    {!! $rec->fixation_amt ? $rec->fixation_amt : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                </td>



                <td width="100px" style="font-size:10pt; text-align: right">
                @foreach($empRecomend as $rec)
                @if( $row->employee_id == $rec->employee_id)
                    {!! $rec->proposed_salary ? $rec->proposed_salary : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                </td>
                <td width="60px" style="font-size:10pt; text-align: right">
                @foreach($empRecomend as $rec)
                @if($row->employee_id == $rec->employee_id)
                    {!! $rec->descriptions ? $rec->descriptions : "" !!} <br/>  <br/>  
                  
                @endif
                @endforeach
                </td>

            </tr>

            @php($sl++)
            @endif

            @endforeach
        </tbody>

    </table>
    @endif


    @endforeach
    @endif

    <div class="blank-space"></div>

    <div>Total Manpower : {!! $employees->count() !!}</div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>

</html>