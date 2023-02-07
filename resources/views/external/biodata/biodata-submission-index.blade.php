@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Applicants Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


        <div class="card text-center bg-light mb-3" style="width: 60rem;">
            <div class="card-header">
                Applicants Details
            </div>
            <div class="card-body">
                <form action="{!! url('bioData/save') !!}" id="bio-data-form"  method="post" accept-charset="utf-8">
                    {{ csrf_field() }}


                    <div class="form-group row required">
                        <label for="name" class="col-sm-3 col-form-label text-md-right">Name</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fathers_name" class="col-sm-3 col-form-label text-md-right">Father's Name</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="fathers_name" id="fathers_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mothers_name" class="col-sm-3 col-form-label text-md-right">Mother's Name</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="mothers_name" id="mothers_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="mobile_no" class="col-sm-3 col-form-label text-md-right">Mobile No</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="applied_post" class="col-sm-3 col-form-label text-md-right">Applied Post</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                {!! Form::select('circular_id',$circulars,null,array('id'=>'circular_id','class'=>'form-control','autofocus')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="speciality" class="col-sm-3 col-form-label text-md-right">Speciality</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="speciality" id="speciality" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="submission_date" class="col-sm-3 col-form-label text-md-right">Submission Date</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="submission_date" id="submission_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reference_name" class="col-sm-3 col-form-label text-md-right">Reference Name</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="reference_name" id="reference_name" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="remarks" class="col-sm-3 col-form-label text-md-right">Remarks</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="remarks" cols="50" rows="4" id="remarks"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>


        @if(!empty($data))

            <div class="card text-center bg-light mb-3" style="width: 60rem;">
                <div class="card-header">
                    Applicants Details
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-success table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Issue No</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Applied Post</th>
                                <th>Submission Date</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{!! $row->issue_number !!}</td>
                                <td>{!! $row->name !!}</td>
                                <td>{!! $row->mobile_no !!}</td>
                                <td>{!! $row->circular->circular_name !!}</td>
                                <td>{!! $row->submission_date !!}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>


        @endif


    </div> <!--/.Container-->






@endsection

@push('scripts')

    <script>

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