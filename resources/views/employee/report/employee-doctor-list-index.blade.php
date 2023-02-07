@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Doctor List</h2>
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
                    <div class="card-header">Doctor List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/allDoctorListIndex') }}" >
                        <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">

                                    {!! Form::select('department',['all'=>'All Doctor','Clinical'=>'Clinical Service'],null,['id'=>'department', 'class'=>'form-control','placeholder'=>'Select One']) !!}
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
                    <div class="card-header">Section Wise Doctor</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empsectionDoctorEmpList') }}" >
                        
                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">Section</label>
                                <div class="col-md-6">
                                {!! Form::select('id',$sections,null,['id'=>'id', 'class'=>'form-control','placeholder'=>'Select One']) !!}
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
                    <div class="card-header"> Doctor Special</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/specialempDoctorEmpList') }}" >
                        
                          

                      

                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Special</label>
                                <div class="col-md-6">
                                
                                    {!! Form::select('special_id',['consultant'=>'Consultant','register'=>'Register','asstregister'=>'Asst.Register','specialist'=>'Specialist','clinicalStaff'=>'Clinical Doctor','smo'=>'Senior Medical Oficer','mo'=>'Medical Oficer',],null,['id'=>'status_id', 'class'=>'form-control','placeholder'=>'Select One']) !!}
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
         <!--/.Container-->

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