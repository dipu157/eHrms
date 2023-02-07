@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Leave Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    {{--<link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />--}}
    {{--<script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>--}}
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>
    </div> <!--/.Container-->

    @if(!empty($emp_info))

        <div class="container-fluid">
            <div  class="panel panel-default thumbnail">

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"><img src="{!! isset($emp_info->personal->photo) ? asset($emp_info->personal->photo) : ($emp_info->personal->gender == 'M' ? asset('assets/images/male.jpeg') : asset('assets/images/female.png'))  !!}" width="200px" height="200px" class="img-rounded img-responsive" alt="..">
                            <br/>
                            <h3 style="font-weight: bold">{!! $emp_info->personal->professional->employee_id !!} : {!!$emp_info->personal->full_name !!}<br/>
                                {!!$emp_info->personal->professional->designation->name !!}<br/>
                                {!!isset($emp_info->personal->professional->department_id) ? $emp_info->personal->professional->department->name : '' !!}
                            </h3>

                        </div>

                        <div class=" col-md-9 col-lg-9 ">

                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>Title:</td>
                                    <td>{!! $emp_info->personal->title->name !!}</td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td>{!! $emp_info->personal->full_name !!}</td>
                                </tr>

                                <tr>
                                    <td>Email:</td>
                                    <td>{!! $emp_info->personal->email !!}</td>
                                </tr>

                                <tr>
                                    <td>Date of Joining:</td>
                                    <td>{!! \Carbon\Carbon::parse($emp_info->professional->joining_date)->format('d-M-Y') !!}</td>
                                </tr>

                                <tr>
                                    <td>Blood Group:</td>
                                    <td>{!! $emp_info->personal->blood_group !!}</td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div> <!--/.Container-->


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Leave Statistics for the Year {!! $c_year !!}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th style="font-weight: bold">Leave Type</th>
                                <th style="font-weight: bold">Leave Year</th>
                                <th style="font-weight: bold">Total Leave</th>
                                <th style="font-weight: bold">Enjoyed</th>
                                <th style="font-weight: bold">Balance</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emp_info->personal->leave as $row)
                                @if($row->leave_year == $c_year)
                                <tr>
                                    <td>{!! $row->type->name !!}</td>                            
                                    <td>{!! $row->leave_year !!}</td>
                                    <td>{!! $row->leave_eligible !!}</td>
                                    <td>{!! $row->leave_enjoyed !!}</td>
                                    <td>{!! $row->leave_balance !!}</td>
                                </tr>
                                @endif
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Leave Statistics for the Year {!! $c_year-1 !!}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th style="font-weight: bold">Leave Type</th>
                                <th style="font-weight: bold">Leave Year</th>
                                <th style="font-weight: bold">Total Leave</th>
                                <th style="font-weight: bold">Enjoyed</th>
                                <th style="font-weight: bold">Balance</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emp_info->personal->leave as $row)
                                @if($row->leave_year == $c_year-1)
                                <tr>
                                    <td>{!! $row->type->name !!}</td>
                                    <td>{!! $row->leave_year !!}</td>
                                    <td>{!! $row->leave_eligible !!}</td>
                                    <td>{!! $row->leave_enjoyed !!}</td>
                                    <td>{!! $row->leave_balance !!}</td>
                                </tr>
                                 @endif
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br/>


        <div class="row">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Current Year Leave History
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th style="font-weight: bold">Leave Type</th>
                                <th style="font-weight: bold">Leave Year</th>
                                <th style="font-weight: bold">From</th>
                                <th style="font-weight: bold">Reason</th>
                                <th style="font-weight: bold">Location</th>
                                <th style="font-weight: bold">Alternate</th>
                                <th style="font-weight: bold">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emp_info->personal->leaveStatus as $row)
                                @if($row->leave_year == $c_year)
                                <tr>
                                    <td>{!! $row->type->name !!}<br> <span style="color: rgba(125,0,0,0.72)">{!! $row->leave_id == 3 ? $row->duty_date : null !!}</span> </td>
                                    <td>{!! $row->leave_year !!}</td>
                                    <td>{!! $row->from_date !!}<br/>{!! $row->to_date !!}</td>
                                    <td>{!! $row->reason !!}</td>
                                    <td>{!! $row->location !!}</td>
                                    <td>{!! !is_null($row->alternate_id) ? $row->alternate_id : null!!}</td>
                                    <td>{!! $row->status == 'D' ? 'Rejected' : ($row->status == 'C' ? 'Applied' : ($row->status == 'R' ? 'Recommended' : ($row->status == 'K' ? 'Acknowledged' : ($row->status == 'A' ? 'Approved' : 'Canceled')))) !!}</td>
                                </tr>
                                @endif
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Last Year Leave History
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th style="font-weight: bold">Leave Type</th>
                                <th style="font-weight: bold">Leave Year</th>
                                <th style="font-weight: bold">From</th>
                                <th style="font-weight: bold">Reason</th>
                                <th style="font-weight: bold">Location</th>
                                <th style="font-weight: bold">Alternate</th>
                                <th style="font-weight: bold">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emp_info->personal->leaveStatus as $row)
                                @if($row->leave_year == $c_year-1)
                                <tr>
                                    <td>{!! $row->type->name !!}<br> <span style="color: rgba(125,0,0,0.72)">{!! $row->leave_id == 3 ? $row->duty_date : null !!}</span> </td>
                                    <td>{!! $row->leave_year !!}</td>
                                    <td>{!! $row->from_date !!}<br/>{!! $row->to_date !!}</td>
                                    <td>{!! $row->reason !!}</td>
                                    <td>{!! $row->location !!}</td>
                                    <td>{!! !is_null($row->alternate_id) ? $row->alternate_id : null!!}</td>
                                    <td>{!! $row->status == 'D' ? 'Rejected' : ($row->status == 'C' ? 'Applied' : ($row->status == 'R' ? 'Recommended' : ($row->status == 'K' ? 'Acknowledged' : ($row->status == 'A' ? 'Approved' : 'Canceled')))) !!}</td>
                                </tr>
                                @endif
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    @endif



@endsection

@push('scripts')



@endpush