@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Promotion For <strong style="color: #980000">{!! $emp_data->full_name !!}</strong>  : {!! $emp_data->professional->designation->name !!} : {!! $emp_data->professional->department->name !!}</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>
    {{--<link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />--}}
    {{--    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>--}}

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>

        </div>


        <div class="container-fluid">

            {!! Form::open(['url' => 'employee/promotion', 'method' => 'post']) !!}

            <div class="card text-center">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label for="designation_id" class="col-sm-3 col-form-label">Promoted To</label>
                        <div class="col-sm-9">
                            {!! Form::select('designation_id',$designations, isset($data->professional->designation_id) ? $data->professional->designation_id : null,  array('id'=>'designation_id','class'=>'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="effective_date" class="col-sm-3 col-form-label">Effective Date</label>
                        <div class="col-sm-9">
                            <input type="text" name="effective_date" id="effective_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label">Description/Notes</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" cols="50" rows="4" id="description"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="employee_p_id" id="employee_p_id" class="form-control" value="{!! $id !!}" />


                </div>
                <div class="card-footer text-muted">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Submit</button>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}


        </div>



    </div> <!--/.Container-->

@endsection

@push('scripts')
    <script>

$( function() {
    $( "#effective_date" ).datetimepicker({
        format:'d-m-Y',
        timepicker: false,
        closeOnDateSelect: true,
        scrollInput : false,
        inline:false
    });

} );

    </script>




@endpush