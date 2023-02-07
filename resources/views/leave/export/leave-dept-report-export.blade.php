

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


<div>
    <table style="width:100%">
        <tr>
            <td style="width:5%"></td>
            <td style="width:90%">
                <table style="width:100%" class="order-bank">
                    <thead>
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:14pt;color:#000000; ">

                        Leave Report </span>: {!! $employees->count() !!}</td>
                    </tr>
                   
                    <tr>
                        <td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:11pt;color:#000000; ">Report Date From {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To  {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}<br/>
                        </span></td>
                    </tr>
                    </thead>
                </table>
            </td>
            <td style="width:5%"></td>
        </tr>
    </table>
</div>

                            
@foreach($departments as $i=>$dept)

      
@if($data->contains('department_id',$dept->department_id))

    {{--<div>Department : {!! $dept->name !!} :  {!! $data->count() !!}</div>--}}
   
    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        <tr>
            <th style="text-align: left; font-size: 10px; font-weight: bold">Department : {!! $dept->department->name !!} </th>

        </tr>
        <tr class="row-line">
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="135px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="160px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="100px" style="text-align: left; font-size: 10px; font-weight: bold">Leave Name</th>
            <th  width="55px" style="text-align: center; font-size: 10px; font-weight: bold">Date</th>
        </tr>
        </thead>
        <tbody>
        @php($sl = 1)

       
        @foreach($data as $row)
            @if($dept->department_id == $row->department_id)

                <tr>
                    <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $sl !!}</td>
                   
                    <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                    <td width="135px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!} </td>
                    <td width="160px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->designation->name !!} </td>
                    <td  width="100px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! $row->leave->name !!}</td>
                    <td width="55px" style="border-bottom-width:1px; font-size:8pt; text-align: center">{!! \Carbon\Carbon::parse($row->attend_date)->format('d-M-Y') !!}</td>
                </tr>
                @php($sl++)
            @endif
        @endforeach
        {{--@endforeach--}}
        </tbody>
    </table>
    <div class="blank-space"></div>
@endif


@endforeach
<div class="blank-space"></div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
<script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
</body>
</html>

