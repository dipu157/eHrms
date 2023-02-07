@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Phone List Report</h2>
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
                    <div class="card-header">Department Wise List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('phone/report/department') }}" >

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'ALL Department']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('search_id',1) !!}

                            <div class="form-group row mb-0">
                                <div class="col-md-3 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
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
                    <div class="card-header">Location Wise List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('phone/report/location') }}" >

                            <div class="form-group row">
                                <label for="designation_id" class="col-md-4 col-form-label text-md-right">Location</label>
                                <div class="col-md-6">
                                    {!! Form::select('location_id',$locations,null,['id'=>'location_id', 'class'=>'form-control','placeholder'=>'ALL Location']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('search_id',1) !!}

                            <div class="form-group row mb-0">
                                <div class="col-md-3 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div> <!--/.Container-->

@endsection