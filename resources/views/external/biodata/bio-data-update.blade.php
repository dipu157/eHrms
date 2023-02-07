@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Applicants Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


            <form class="form-inline" method="get" action="{{ route('bioData/updateIndex') }}">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="search_name" class="sr-only">Search by Name</label>
                    <input type="text" class="form-control typeahead" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">
                </div>

                {!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}

                <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-search">Search</i></button>
            </form>

        @if(!empty($data))

            <div class="card text-center bg-light mb-3" style="width: 60rem;">
            <div class="card-header">
                Biodata Details
            </div>
            <div class="card-body">
                <form action="{!! url('bioData/update') !!}" id="bio-data-form"  method="post" accept-charset="utf-8">
                    {{ csrf_field() }}


                    <div class="form-group row required">
                        <label for="name" class="col-sm-3 col-form-label text-md-right">Name</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="name" id="name" value="{!! $data->name !!}" class="form-control" required>
                                {!! Form::hidden('update_id', $data->id, array('id' => 'update_id')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="mobile_no" class="col-sm-3 col-form-label text-md-right">Mobile No</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="mobile_no" id="mobile_no" value="{!! $data->mobile_no !!}" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="circular_id" class="col-sm-3 col-form-label text-md-right">Applied Post</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                {!! Form::select('circular_id',$circulars,$data->circular_id,['id'=>'circular_id','class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="speciality" class="col-sm-3 col-form-label text-md-right">Speciality</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="speciality" id="speciality" value="{!! $data->speciality !!}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="submission_date" class="col-sm-3 col-form-label text-md-right">Submission Date</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="submission_date" id="submission_date" value="{!! \Carbon\Carbon::parse($data->submission_date)->format('d-m-Y') !!}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reference_name" class="col-sm-3 col-form-label text-md-right">Reference Name</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="reference_name" value="{!! $data->reference_name !!}" id="reference_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="board_decision" class="col-sm-3 col-form-label text-md-right">Applicants Status</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                {!! Form::select('app_status_id',$app_status_list,$data->app_status_id,['id'=>'app_status_id','class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="joining_date" class="col-sm-3 col-form-label text-md-right">Joinning Date</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="joining_date" id="joining_date" value="{!! $data->joining_date !!}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="remarks" class="col-sm-3 col-form-label text-md-right">Remarks</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="remarks" cols="50" rows="4" id="remarks">{!! $data->remarks !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>

        @endif


    </div> <!--/.Container-->


@endsection

@push('scripts')

    <script>

        var autocomplete_path = "{{ url('autocomplete/biodataSearch') }}";

        $(document).on('click', '.form-control.typeahead', function() {

            $(this).typeahead({
                minLength: 2,
                displayText:function (data) {
                    return data.name + ' : ' + data.mobile_no;
                },

                source: function (query, process) {
                    $.ajax({
                        url: autocomplete_path,
                        type: 'GET',
                        dataType: 'JSON',
                        data: 'query=' + query ,
                        success: function(data) {
                            return process(data);
                        }
                    });
                },
                afterSelect: function (data) {

                    document.getElementById('search_id').value = data.id;
                }
            });
        });



        $( function() {

            $( "#submission_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#joining_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });



        } );


        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>

@endpush