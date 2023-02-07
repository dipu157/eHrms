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
            padding:4px;
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
            background: #ffdab9;
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
    <hr style="height: 2px">
</table>

<div class="blank-space"></div>

<div>
    <table style="width:100%">
        <tr>
            <td style="width:5%"></td>
            <td style="width:90%">
                <table style="width:100%" class="order-bank">
                    <thead>
                    <tr>
                    @if(!empty($special_id))<td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">  {!! $special_id === 'consultant' ? 'Consultant Doctor List' : ($special_id =='register' ? 'Register Doctor List' : ($special_id == 'specialist' ? 'Specialist Doctor List' : ($special_id == 'clinicalStaff' ? 'Clinical Doctor List': ($special_id == 'smo' ? 'Senior Medical Oficer Doctor List' : ($special_id == 'mo' ? 'Medical Oficer Doctor List' : 'Doctor List'))))) !!}  </span></td>@endif 
                    @if(!empty($department))<td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; "> {!! $department === 'all' ? 'All Doctor List' : ($department =='Clinical' ? 'Clinical Services All Section Doctor List' : 'Doctor List') !!} </span></td>@endif 
  <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">  Clinical Services Doctor List</span></td>
                </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


@foreach($sectionss as $i=>$sect)

@if($employees->contains('section_id',$sect->section->id))

        {{-- <div>Total Manpower : {!! $employees->count() !!}</div> --}}

        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>
            <tr>
                <th style="text-align: center; font-size: 10px; font-weight: bold"> {!! $sect->section->name !!}</th>
 
            </tr>
    
            <tr class="row-line">
                <th width="25px" style="text-align: center; font-size: 10px; font-weight: bold">SL</th>
                <th width="30px" style="text-align: center; font-size: 10px; font-weight: bold">PF No</th>
                <th width="50px" style="text-align: center; font-size: 10px; font-weight: bold">ID</th>

                <th width="120px" style="text-align: center; font-size: 10px; font-weight: bold">Name</th>
                <th width="70px" style="text-align: center; font-size: 10px; font-weight: bold">Joining Date</th>
                <th width="110px" style="text-align: center; font-size: 10px; font-weight: bold">Designation</th>
                <th width="110px" style="text-align: center; font-size: 10px; font-weight: bold">Qualification</th>
                <th width="110px" style="text-align: center; font-size: 10px; font-weight: bold">Service <br>Length</th>
                <th width="60px" style="text-align: center; font-size: 10px; font-weight: bold">Remarks</th>
                
            </tr>
            </thead>
            <tbody>
            @php($sl = 1)

            @foreach($employees as $row)
            @if($row->section_id == $sect->section->id)
                @php($secname = $employees->where('section_id',$row->section_id))
                   
                    <tr class="row-line">
                        <td width="25px" style="font-size:8pt; text-align: center">{!! $sl !!}</td>
                        <td width="30px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->pf_no !!}</td>
                        <td width="50px" style="font-size:8pt; text-align: center">{!! $row->employee_id !!}</td>

                        <td width="120px" style="font-size:8pt; text-align: center">{!!$row->personal->full_name !!}</td>
                        <td width="70px" style="font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->joining_date)->format('Y-m-d') !!} </td>
                        <td width="110px" style="font-size:8pt; text-align: center">{!! $row->designation->name !!} </td>

                        <td width="110px" style="font-size:8pt; text-align: center">{!! $row->personal->last_education !!} </td>

                        <td width="110px" style="font-size:8pt; text-align: center"> {{  date_diff(new \DateTime($row->joining_date), new \DateTime())->format("%y Years, %m Months") }}</td>
                 
                        <td width="60px" style="text-align: center; font-size: 10px; font-weight: bold"></td>
                        
                    </tr>
                    @php($sl++)
                    @endif
             
            @endforeach
            </tbody>
        </table>
       
     
        <div class="blank-space"></div>
        
        <div>Total</span>  :  {!! $secname->count() !!} </div>
        <div class="blank-space"></div>
   
        @endif

@endforeach

<div>Total Doctor : {!! $employees->count() !!}</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>--}}
</body>
</html>

