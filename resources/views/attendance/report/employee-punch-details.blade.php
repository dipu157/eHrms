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
                    <h3 style="font-weight: bold">Department Name : {!! $data->department->name !!}<br/>
                        Report Title: List Of Present Employees of the date : {!! $data->attend_date !!}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-info table-striped">

                        <thead>
                        <tr>
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
                            <tr>
                                <td>{!! $data->employee_id !!}</td>
                                <td>{!! $data->professional->personal->full_name !!}</td>
                                <td>{!! $data->shift->name !!}<br/>{!! \Carbon\Carbon::parse($data->shift->from_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($data->shift->to_time)->format('g:i A') !!}</td>
                                <td>{!! isset($data->entry_time) ? \Carbon\Carbon::parse($data->entry_time)->format('g:i A') : '' !!}</td>
                                <td>{!! isset($data->exit_time) ? \Carbon\Carbon::parse($data->exit_time)->format('g:i A') : '' !!}</td>
                                <td>{!! $data->overtime_hour !!}</td>
                                <td>{!! $data->Status !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        @endif


        @if(!empty($punchs))

            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Punch Details</h3>
                </div>
                <div class="card-body">
                    <table class="table table-info table-striped">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Punch Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($punchs as $i=>$row)
                            <tr>
                                <td>{!! $i+1 !!}</td>
                                <td>{!! \Carbon\Carbon::parse($row->attendance_datetime)->format('d-M-Y g:i:s A') !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endif

    </div> <!--/.Container-->

@endsection