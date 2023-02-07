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
                    <div class="card-header">Date Range Employee List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/dateEmpListWStatusIndex') }}" >

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="from_date" id="from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="to_date" id="to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Working Status</label>
                                <div class="col-md-6">
                                    {{-- {!! Form::select('status_id',$wStatus,null,['id'=>'status_id', 'class'=>'form-control','placeholder'=>'Select One']) !!} --}}

                                    {!! Form::select('status_id',['0'=>'All Regular Employee','1'=>'New Join','2'=>'Regular','3'=>'Probationary','4'=>'Suspended','5'=>'Resigned','6'=>'Unauthorised Absent','7'=>'Contractual','8'=>'Dismissed','9'=>'Discontinued','11'=>'Released','10'=>'All Left Employee'],null,['id'=>'status_id', 'class'=>'form-control','placeholder'=>'Select One']) !!}
                                </div>
                            </div>

                            {{--{!! Form::hidden('search_id',1) !!}--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="summery">Summery</button>
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
                    <div class="card-header">Month Wise Employee List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/monthEmpListWStatusIndex') }}" >

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">Year</label>
                                <div class="col-md-6">
                                    {!! Form::selectYear('search_year', 2019, 2025,2019,array('id'=>'search_year','class'=>'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-4 col-form-label text-md-right">Month</label>
                                <div class="col-md-6">
                                    {!! Form::selectMonth('search_month',$month,['id' => 'search_month','class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Working Status</label>
                                <div class="col-md-6">

                                    {!! Form::select('status_id',['1'=>'All Regular Employee','2'=>'All Left Employee'],null,['id'=>'status_id', 'class'=>'form-control','placeholder'=>'Select One']) !!}
                                </div>
                            </div>

                            {{--{!! Form::hidden('search_id',1) !!}--}}

                            <div class="form-group row mb-0">
                                {{-- <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="summery">Summery</button>
                                </div> --}}
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
                    <div class="card-header">Date Range Punish List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/punishEmpListIndex') }}" >

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="from_date1" id="from_date1" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="to_date1" id="to_date1" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Punish Status</label>
                                <div class="col-md-6">
                                    {{-- {!! Form::select('status_id',$wStatus,null,['id'=>'status_id', 'class'=>'form-control','placeholder'=>'Select One']) !!} --}}

                                    {!! Form::select('punish_id',['1'=>'Suspention','2'=>'Show Case','3'=>'Warning Letter','4'=>'Miscellaneous'],null,['id'=>'punish_id', 'class'=>'form-control','placeholder'=>'Select One']) !!}
                                </div>
                            </div>

                            {{--{!! Form::hidden('search_id',1) !!}--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-8 text-md-right">
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


        $(document).ready(function(){

            $( "#from_date1" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#to_date1" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush