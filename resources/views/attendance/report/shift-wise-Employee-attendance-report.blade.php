@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Shift Wise Employee Attendance</h2>
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
            <div class="col-md-8">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">

                        <h2>Status Wise Employee Report </h2> <br><br>

                        <form method="get" action="{{ route('attendance/dateShiftReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="report_date" class="col-md-4 col-form-label text-md-right">Select Department & Date</label>

                                <div class="col-md-4">
                                    <div class="form-group">
                                {!! Form::select('department_id',$departments, null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <input type="text" name="report_date" id="report_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                                </div>

                                
                            </div>

                            {{--<div class="form-group row">--}}
                                {{--<label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee ID</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Enter ID Or Leave Empty If Need All" autocomplete="off" />--}}
                                {{--</div>--}}
                            {{--</div>--}}



                            <div class="form-group row mb-0">
                            <div class="col-md-4 text-md-right">
                                <button type="submit" class="btn btn-primary" name="action" value="summary">summary</button>
                            </div>
                            <div class="col-md-4 text-md-right">
                                <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                            </div>
                            <div class="col-md-4 text-md-right">
                                <button type="submit" class="btn btn-success" name="action" value="download">Excel</button>
                            </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">

                        <h2>Punch Wise Employee Report </h2> <br><br>
                        
                        <form method="get" action="{{ route('attendance/dateShiftPunchReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="report_date" class="col-md-4 col-form-label text-md-right">Select Department & Date</label>

                                <div class="col-md-4">
                                    <div class="form-group">
                                {!! Form::select('department_id',$departments, null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <input type="text" name="report_date2" id="report_date2" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                                </div>

                                
                            </div>


                            <div class="form-group row mb-0">
                            
                            <div class="col-md-4 text-md-right">
                                <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                            </div>
                            <div class="col-md-4 text-md-right">
                                
                            </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
        });

        $(document).ready(function(){

            $( "#report_date2" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush