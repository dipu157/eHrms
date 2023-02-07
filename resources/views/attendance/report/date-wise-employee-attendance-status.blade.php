@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Attendance</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>



        @if(!empty($data))

            <div class="card">
                <div class="card-header">
                   <h3 style="font-weight: bold">Department Name : {!! $data[0]->department->name !!}<br/>
                   Report Title: List Of Present Employees of the date : {!! $data[0]->attend_date !!}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-info table-striped">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Shift</th>
                            <td>Entry Time</td>
                            <th>Exit Time</th>
                            <th>Over Time</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($p=0)
                        @foreach($data as $i=>$row)
                            @if($row->Status == 'Present')
                                @php($p++)
                                <tr>
                                    <td>{!! $p !!}</td>
                                    <td>{!! $row->employee_id !!}</td>
                                    <td>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                                    <td>{!! isset($row->entry_time) ? \Carbon\Carbon::parse($row->entry_time)->format('g:i A') :'' !!}</td>
                                    <td>{!! isset($row->exit_time) ? \Carbon\Carbon::parse($row->exit_time)->format('g:i A') : '' !!}</td>
                                    <td>{!! $row->overtime_hour !!}</td>
                                    <td>{!! $row->Status !!}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Department Name : {!! $data[0]->department->name !!}<br/>
                        Report Title: List Of Employees Enjoying Off Day of the date : {!! $data[0]->attend_date !!}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-secondary table-striped">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Shift</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($off=0)
                        @foreach($data as $i=>$row)
                            @if($row->Status == 'OffDay')
                                @php($off++)
                                <tr>
                                    <td>{!! $off !!}</td>
                                    <td>{!! $row->employee_id !!}</td>
                                    <td>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                                    <td>{!! $row->Status !!}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Department Name : {!! $data[0]->department->name !!}<br/>
                        Report Title: List Of Employees Enjoying Leave of the date : {!! $data[0]->attend_date !!}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-secondary table-striped">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Shift</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($lv=0)
                        @foreach($data as $i=>$row)
                            @if($row->Status == 'InLeave')
                                @php($lv++)
                                <tr>
                                    <td>{!! $lv !!}</td>
                                    <td>{!! $row->employee_id !!}</td>
                                    <td>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                                    <td>{!! $row->Status !!}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Department Name : {!! $data[0]->department->name !!}<br/>
                        Report Title: List Of Absent Employees of the date : {!! $data[0]->attend_date !!}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-primary table-striped">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Shift</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($ab=0)
                        @foreach($data as $i=>$row)
                            @if($row->Status == 'Absent')
                                @php($ab++)
                                <tr>
                                    <td>{!! $ab !!}</td>
                                    <td>{!! $row->employee_id !!}</td>
                                    <td>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                                    <td>{!! $row->Status !!}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>





        @endif

    </div> <!--/.Container-->

@endsection