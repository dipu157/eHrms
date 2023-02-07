@extends('layouts.master')
@section('pagetitle')
    <h2 class="no-margin-bottom">Shift Wise Employee List Detail</h2>
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
            <div class="col-md-10">
                <div class="card">

                    <div class="card-body">

                        <h3>Department Wise Employee</h3>

                        <form class="form-inline" id="search-form" method="get" action="{{ route('roster/printDeptWiseEmployeeShiftIndex') }}">

                            <div class="form-group">
                                {{-- {!! Form::select('session_id',['O'=>'OFF DAY','G'=>'GENERAL','M'=>'MORNING','E'=>'EVENING','N'=>'NIGHT','R'=>'NO ROSTER'], null,['id'=>'session_id', 'class'=>'form-control']) !!} --}}
                                {!! Form::select('shift_id',$shifts, null,['id'=>'shift_id', 'class'=>'form-control','placeholder'=>'Select Shift']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::select('department_id',$departments, null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                            </div>  

                            <div class="form-group">

                                <label for="report_date" class="col-md-3 col-form-label text-md-right">Report Date</label>

                                <input type="text" name="report_date" id="report_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                            </div>


                            <div class="form-group">
                                <div class="mx-sm-1 text-md-right">
                                    <button type="submit" class="btn btn-secondary btn-sm" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    {{-- <div class="card-body">

                        <h3>Shift Wise Employee</h3>

                        <form class="form-inline" id="search-form" method="get" action="{{ route('roster/printShiftWiseEmployeeIndex') }}">

                            <div class="form-group">
                                {!! Form::select('shift_id',$shifts, null,['id'=>'shift_id', 'class'=>'form-control','placeholder'=>'Select Shift']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::select('department_id',$departments, null,['id'=>'department_id', 'class'=>'form-control']) !!}
                            </div>  

                            <div class="form-group">

                                <label for="report_date" class="col-md-3 col-form-label text-md-right">Report Date</label>

                                <input type="text" name="report_date1" id="report_date1" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                            </div>


                            <div class="form-group">
                                <div class="mx-sm-1 text-md-right">
                                    <button type="submit" class="btn btn-secondary btn-sm" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
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

            $( "#report_date1" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush