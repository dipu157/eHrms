@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Salary & Bonus Report</h2>
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
                    <div class="card-header">Salary Report</div>
                    <div class="card-body">
                        <form method="get" action="{{ route('payroll/salaryReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">Year</label>
                                <div class="col-md-6">
                                    {!! Form::selectYear('year_id',2019,2025, 2019,['id'=>'year_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Month</label>
                                <div class="col-md-6">
                                    {!! Form::selectMonth('month_id',null,['id'=>'month_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="download">Download</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>

             <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Bonus Report</div>
                    <div class="card-body">
                        <form method="get" action="{{ route('payroll/bonusReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">Year</label>
                                <div class="col-md-6">
                                    {!! Form::selectYear('year_id',2019,2025, 2019,['id'=>'year_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Month</label>
                                <div class="col-md-6">
                                    {!! Form::selectMonth('month_id',null,['id'=>'month_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="download">Download</button>
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

            $( "#run_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>
@endpush