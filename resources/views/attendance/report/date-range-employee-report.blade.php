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
                    <h3 style="font-weight: bold"> {!! $data[0]->employee_id !!} :  {!! $data[0]->professional->personal->full_name !!}<br/>
                        Department Name : {!! $data[0]->department->name !!}<br/>
                        Report Title: Employee Attendance History : </h3>
                </div>
                <div class="card-body">
                    <table class="table table-info table-striped">

                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shift</th>
                            <td>Entry Time</td>
                            <th>Exit Time</th>
                            <th>Over Time</th>
                            <th>Late</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $i=>$row)
                            <tr {!! $row->attend_status == 'A' ? 'style="background-color: rgba(123,0,0,0.25)"' : ($row->holiday_flag == 1 ? 'style="background-color: rgba(255,204,255,0.2)"' : ($row->leave_flag == 1 ? 'style="background-color: rgba(153,153,102,0.2)"' : null)) !!} >
                                <td>{!! $row->attend_date !!}</td>
                                <td>{!! $row->shift->name !!}<br/>{!! \Carbon\Carbon::parse($row->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->shift->to_time)->format('g:i A') !!}</td>
                                <td>{!! is_null($row->entry_time) ? '' : \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!}</td>
                                <td>{!! is_null($row->exit_time) ? '' : \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!}</td>
                                <td>{!! $row->overtime_hour !!}</td>
                                <td>{!! $row->late_minute !!}</td>
                                <td>{!! $row->attend_status == 'P' ? 'Present' : ($row->offday_flag == 1 ? 'Off Day' : ($row->holiday_flag == 1 ? 'Public Holiday' : ($row->leave_flag == 1 ? 'In leave' : 'Absent'))) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endif

    </div> <!--/.Container-->

@endsection