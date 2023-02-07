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
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:15pt;color:#000000; ">Phone List</span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>


@foreach($locations as $i=>$dept)

    @if($data->contains('location_id',$dept->id))

        <table class="table order-bank" width="90%" cellpadding="2">

            <thead>
            <tr>
                <th style="text-align: left; font-size: 10px; font-weight: bold">Location : {!! $dept->location !!}</th>
            </tr>
            <tr class="row-line">
                <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
                <th width="150px" style="text-align: left; font-size: 10px; font-weight: bold">Used By</th>
                <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Phone No</th>
                <th width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Department</th>
                <th width="100px" style="text-align: right; font-size: 10px; font-weight: bold">Remarks</th>
                
            </tr>
            </thead>
            <tbody>
            @php($sl = 1)

            @foreach($data as $row)
            
                @if($dept->id == $row->location_id)
                @php($dptname = $data->where('location_id',$row->location_id))
                    <tr class="row-line">
                        <td width="40px" style="font-size:8pt; text-align: left">{!! $sl !!}</td>
                        <td width="150px" style="font-size:8pt; text-align: left">{!! $row->used_by !!}</td>
                        <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->phone_no !!}</td>
                        <td width="120px" style="font-size:8pt; text-align: left">{!! $row->department->name !!}</td>
                        <th width="100px" style="text-align: right; font-size: 10px; font-weight: bold"></th>
                        
                    </tr>
                    @php($sl++)
                   
                @endif
             
            @endforeach
            </tbody>
        </table>
       
        <div class="blank-space"></div>
        
        <div>Location Phone </span>: {!! $dptname->count() !!}</div>
        <div class="blank-space"></div>
    @endif


@endforeach

<div>Total Phone : {!! $data->count() !!}</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>

