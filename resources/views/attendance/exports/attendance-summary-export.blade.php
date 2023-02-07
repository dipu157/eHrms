
<table border="0" cellpadding="0">
    <tr>
        <td colspan="8" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">BRB Hospitals Ltd</span></td>

    </tr>

    <tr>
        <td colspan="8" style="text-align: right"><span style="font-family:times;font-weight:bold; padding-right: 100px; line-height: 130%; height: 300%; font-size:15pt;color:black;">77/A, East Rajabazar, <br/> West Panthapath, Dhaka-1215</span></td>

    </tr>

</table>


<div>

    <table>
        <thead>
            <tr>
                <td colspan="8">Department Name : {!! $final[0]->department_name !!}</td>
            </tr>
            <tr>
                <td colspan="8"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">Attendance Summery From {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To  {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}
                            </span></td>
            </tr>
        </thead>
    </table>

    {{--<table style="width:100%">--}}
        {{--<tr>--}}
            {{--<td style="width:5%"></td>--}}
            {{--<td style="width:90%">--}}
                {{--<table>--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">--}}
                        {{--Department Name : {!! $final[0]->department->name !!}<br/></span></td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td style="width:90%;" colspan="2"><span style="text-align:center; border: #000000; font-family:times;font-weight:bold;font-size:12pt;color:#000000; ">Attendance Summery From {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To  {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}<br/>--}}
                        {{--</span></td>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                {{--</table>--}}
            {{--</td>--}}
            {{--<td style="width:5%"></td>--}}
        {{--</tr>--}}
    {{--</table>--}}
</div>

@if(!empty($final))

    <table class="table order-bank" width="90%" cellpadding="2">

        <thead>
        {{--<tr class="row-line">--}}
            {{--<th rowspan="2" width="25px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>--}}
            {{--<th rowspan="2" width="25px" width="25px" style="text-align: left; font-size: 10px; font-weight: bold">PF.NO</th>--}}
            {{--<th rowspan="2" width="25px" width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>--}}
            {{--<th rowspan="2" width="25px" width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>--}}
            {{--<th rowspan="2" width="25px" width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>--}}
            {{--<th rowspan="2" width="25px" width="50px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>--}}
            {{--<th colspan="4" width="105px" style="text-align: left; font-size: 10px; font-weight: bold">Availed Leave</th>--}}
            {{--<th rowspan="2" width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Public <br/> Holi <br/> day</th>--}}
            {{--<th rowspan="2" width="35px" style="text-align: left; font-size: 10px; font-weight: bold">LWP</th>--}}
            {{--<th rowspan="2" width="35px" style="text-align: left; font-size: 10px; font-weight: bold">LWP for late</th>--}}
            {{--<th rowspan="2" width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Total LWP</th>--}}
            {{--<th rowspan="2" width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Total Working Days</th>--}}
            {{--<th rowspan="2" width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Total Days <br>To be Paid</th>--}}
            {{--<th rowspan="2" width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Remarks</th>--}}
        {{--</tr>--}}

        <tr class="row-line">
            <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">PF.NO</th>
            <th width="40px" style="text-align: left; font-size: 10px; font-weight: bold">ID</th>
            <th width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Name</th>
            <th width="120px" style="text-align: left; font-size: 10px; font-weight: bold">Designation</th>
            <th width="50px" style="text-align: left; font-size: 10px; font-weight: bold">Joining Date</th>
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">CL</th>
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">EL</th>
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SL</th>
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">ML</th>
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">AL</th>
            <th width="20px" style="text-align: left; font-size: 10px; font-weight: bold">SPL</th>
            <!-- <th width="25px" style="text-align: left; font-size: 10px; font-weight: bold">Off <br/> day</th>

            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Public <br/> Holi <br/> day</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">LWP</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">LWP for late</th> -->
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">LWP</th>
            <!-- <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Total Working Days</th>
            <th width="35px" style="text-align: left; font-size: 10px; font-weight: bold">Total Days <br>To be Paid</th>
            <th width="80px" style="text-align: left; font-size: 10px; font-weight: bold">Remarks</th> -->
        </tr>
        </thead>
        <tbody>

        @php($counter = 1)

        @foreach($final as $row)

            <tr style="line-height: 250%">
                <td width="25px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $counter !!}</td>
                <td width="25px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->pf_no !!}</td>
                <td width="40px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->employee_id !!}</td>
                <td width="120px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->professional->personal->full_name !!}</td>
                <td width="120px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->designation_name !!}</td>
                <td width="50px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! \Carbon\Carbon::parse($row->professional->joining_date)->format('d-m-Y') !!}</td>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->casual !!}</td>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->earn !!}</td>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->sick !!}</td>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->mlLeave !!}</td>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->alterLeave !!}</td>
                <td width="20px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->spLeave !!}</td>
                <!-- <td width="25px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->offday !!}</td>

                <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->holiday !!}</td>
                <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->wpLeave !!}</td>
                <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->lateCount !!}</td> -->
                <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->total_lwp !!}</td>
                <!-- <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->present !!}</td>
                <td width="35px" style="border-bottom-width:1px; font-size:8pt; text-align: left">{!! $row->total_pdays !!}</td>
                <td width="80px" style="border-bottom-width:1px; font-size:8pt; text-align: left"></td> -->

                @php($counter ++)
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="blank-space"></div>
@endif