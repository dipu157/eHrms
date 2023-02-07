@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Daily Employee Attendance Report</h2>
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


        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">
                        <form method="get" action="{{ route('attendance/dailyAttendanceStatusIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="report_date" class="col-md-4 col-form-label text-md-right">Report Date</label>

                                <div class="col-md-6">

                                    <input type="text" name="report_date" id="report_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">
                        <form method="get" action="{{ route('attendance/notPresent/leave') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="report_date" class="col-md-12 col-form-label">Not Attendate Employee</label>

                                <div class="col-md-6">
                                    {!! Form::select('status_id',['1'=>'ALL','2'=>'Informed Absent','3'=>'UnauthoriseAbsent','4'=>'In Leave','7'=>'Maternity','8'=>'Quarentine','5'=>'Resigned','6'=>'Suspended'],null,['id'=>'status_id', 'class'=>'form-control']) !!}
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="absent_date" id="absent_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                                                                
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(!empty($data))
            <table class="table table-info table-striped" width="50%">

                <h2><b>Report as on {!! $report_date !!} </b></h2>

                <tbody>
                @foreach($data as $i=>$row)
                    <tr>
                        <td>Total Employee</td>
                        <td>:</td>
                        <td>{!! $row->emp_count !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'present'.'/'.$report_date) !!}">
                                Total Present
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->present !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'No_Roaster_present'.'/'.$report_date) !!}">
                                Present Without Roaster
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->No_Roaster_present !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'General'.'/'.$report_date) !!}">
                        General
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->General !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'Morning'.'/'.$report_date) !!}">
                                Present Morning
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->Morning !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'Evening'.'/'.$report_date) !!}">
                                Present Evening
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->Evening !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'Night'.'/'.$report_date) !!}">
                                Present Night
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->Night !!}</td>
                    </tr>
                    
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'offday'.'/'.$report_date) !!}">
                                Weekly Off Day
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->offday !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'leave'.'/'.$report_date) !!}">
                                In Leave
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->n_leave !!}</td>
                    </tr>
                    <tr>
                        <td>In Public Holiday</td>
                        <td>:</td>
                        <td>{!! $row->holiday !!}</td>
                    </tr>
                    <tr>
                        <td>Next Roster</td>
                        <td>:</td>
                        <td>{!! $row->next_roster !!}</td>
                    </tr>
                    <tr>
                        <td><a href="{!! url('attendance/daily/'.'absent'.'/'.$report_date) !!}">
                                Total Absent
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->absent !!}</td>
                    </tr>
<tr>
          <td><a href="{!! url('attendance/daily/'.'nightAbsent'.'/'.$report_date) !!}">
                                Night Shift Absent
                            </a></td>
                        <td>:</td>
                        <td>{!! $row->NightAb !!}</td>
                    </tr>


                @endforeach
                </tbody>

            </table>

        @endif

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>

        $(document).ready(function(){

            $( "#report_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#absent_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush