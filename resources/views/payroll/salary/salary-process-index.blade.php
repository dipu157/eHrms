@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Monthly Salary & Bonus Process</h2>
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
                        <form method="post" action="{{ route('payroll/salaryProcess') }}" >
                            @csrf


                            <div class="alert alert-warning required" role="alert">
                                Please Make Sure All The Attendance Data Are Already Verified
                            </div>

                            <div class="alert alert-info required" role="alert">
                                 Salary To Be Processed For Year : {!! $period->calender_year !!} Month : {!! $period->month_name !!}<br/>

                            </div>

                            <div class="alert alert-warning required">
                                {!! Form::select('type_id',['1'=>'Salary','2'=>'Bonus'],null,['id'=>'type_id', 'class'=>'form-control']) !!}
                            </div>

                            {!! Form::hidden('period_id',$period->month_id) !!}


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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