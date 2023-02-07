@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">DateRange Leave Report</h2>
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


        <div class="row" id="div-select">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">DateRange Details Leave Status</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('leave/dateRangeStatusPrint') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="s_from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="s_from_date" id="s_from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="s_to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="s_to_date" id="s_to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-6">
                                    {!! Form::select('status_id',['3'=>'Leave'],null,['id'=>'status_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$dept_lists,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>

                                    <button type="submit" class="btn btn-primary" name="action" value="download">Excel</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">DateRange Leave Summary</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('leave/leaveSummaryPrint') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="s_from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="t_from_date" id="t_from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="s_to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="t_to_date" id="t_to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            


                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$dept_lists,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>

                                  
                                </div>
                                {{--<div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-primary" name="action" value="alldept">Summary</button>

                                  
                                </div>--}}
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

            

            $( "#s_from_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#s_to_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
            $( "#t_from_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#t_to_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush