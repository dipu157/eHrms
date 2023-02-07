@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Overtime Salary Report</h2>
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
                        <form method="get" action="{{ route('payroll/overtimeReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="year_id" class="col-md-4 col-form-label text-md-right">Year</label>
                                <div class="col-md-6">
                                    {!! Form::selectYear('year_id',2019,2025, 2020,['id'=>'year_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="month_id" class="col-md-4 col-form-label text-md-right">Month</label>
                                <div class="col-md-6">
                                    {!! Form::selectMonth('month_id',1,['id'=>'month_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$dept_lists,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                            <div class="col-md-4">
                                    
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="summary">Summary</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Department</button>
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


@endpush