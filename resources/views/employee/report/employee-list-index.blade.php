@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee List</h2>
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
                    <div class="card-header">Department Wise Active Employee List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empListIndex') }}" >

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
                                {{-- <div class="col-md-4 text-md-right">
                                    <button type="submit" class="btn btn-default" name="action" value="Allhistory">All History</button>
                                </div> --}}
                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>

                                {{-- <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-success" name="action" value="history">History</button>
                                </div> --}}
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Group Designation Wise Employee</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empBDesigwiseList') }}" >

                            <div class="form-group row">
                                <label for="designation_id" class="col-md-4 col-form-label text-md-right">Designation</label>
                                <div class="col-md-6">
                                {!! Form::select('Bdesignation_Id',$Bdesignation,null,['id'=>'Bdesignation_Id', 'class'=>'form-control','placeholder'=>'ALL Base Designation']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('search_id',1) !!}

                            <div class="form-group row mb-0">
                                <div class="col-md-3 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-default" name="action" value="history">History</button>
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
                    <div class="card-header">Designation Wise Employee History</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empDesigwiseList') }}" >

                            <div class="form-group row">
                                <label for="designation_id" class="col-md-4 col-form-label text-md-right">Designation</label>
                                <div class="col-md-6">
                                {!! Form::select('designation_Id',$designations,null,['id'=>'designation_Id', 'class'=>'form-control','placeholder'=>'ALL Designation']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('search_id',1) !!}

                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-5 text-md-right">
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
                    <div class="card-header">Department Wise Employee History</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empHistoryList') }}" >

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'ALL Department']) !!}
                                </div>
                            </div>

                            {!! Form::hidden('search_id',1) !!}

                            <div class="form-group row mb-0">
                                <div class="col-md-5 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-5 text-md-right">
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
                    <div class="card-header">Working Status Wise Employee</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empListWStatusIndex') }}" >

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Working Status</label>
                                <div class="col-md-6">
                                    {!! Form::select('status_id',$wStatus,null,['id'=>'status_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>

                            {{--{!! Form::hidden('search_id',1) !!}--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-5 text-md-right">
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
                    <div class="card-header">Gender Wise Employee</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empListGenderIndex') }}" >

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Gender</label>
                                <div class="col-md-6">
                                {!! Form::select('gender',['M'=>'Male','F'=>'Female'],null,['id'=>'gender', 'class'=>'form-control','placeholder'=>'Select Gender']) !!}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-5 text-md-right">
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

@push('scripts')

    <script>

        $(document).ready(function(){

            $( "#from_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#to_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush