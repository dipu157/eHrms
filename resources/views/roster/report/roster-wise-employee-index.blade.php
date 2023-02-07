@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Roster Wise Employee List</h2>
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
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">

                        <form class="form-inline" id="search-form" method="get" action="{{ route('roster/printRosterWiseEmployeeIndex') }}">

                            <div class="form-group mb-1 col-3">
                                {!! Form::select('session_id',['O'=>'OFF DAY','G'=>'GENERAL','M'=>'MORNING','E'=>'EVENING','N'=>'NIGHT','R'=>'NO ROSTER'], null,['id'=>'session_id', 'class'=>'form-control', 'placeholder'=>'Select Roster']) !!}
                            </div>


                            <div class="form-group row">
                                <label for="report_date" class="col-md-4 col-form-label text-md-right">Report Date</label>

                                <div class="col-md-6">

                                    <input type="text" name="report_date" id="report_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                                </div>
                            </div>


                            <div class="form-group row mb-0 col-3">
                                <div class="col-md-5 mx-sm-1 text-md-right">
                                    <button type="submit" class="btn btn-secondary btn-sm" name="action" value="print">Print</button>
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

    </script>


@endpush