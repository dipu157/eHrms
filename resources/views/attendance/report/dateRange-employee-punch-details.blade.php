@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Punch Attendance</h2>
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

        @if(!empty($punchs))

            <div class="card">


                    <div class="card-header">
                        <h3 style="font-weight: bold">Punch Details</h3>
                        <h3 style="font-weight: bold"> {!! $punchs[0]->employee_id !!} :  {!! $punchs[0]->professional->personal->full_name !!}<br/>

                            Report Title: Punch Summery Report. Date from : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} to {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>
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