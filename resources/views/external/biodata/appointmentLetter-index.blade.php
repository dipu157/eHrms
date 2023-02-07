@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Applicants Information for Appointment Letter</h2>
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
                <form method="post" action="{!! route('bioData/appointmentsave') !!}"   accept-charset="utf-8">
                    
                    @csrf


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


                    <div class="form-group row">
                        <label for="present_address" class="col-sm-3 col-form-label text-md-right">Present Address</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="present_address" cols="50" rows="4" id="present_address"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="permanent_address" class="col-sm-3 col-form-label text-md-right">Permanent Address</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="permanent_address" cols="50" rows="4" id="permanent_address"></textarea>
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

                    <div class="form-group row required">
                        <label for="designation_id" class="col-sm-3 col-form-label text-md-right">Applied Post</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                {!! Form::select('designation_id',$designations,null,array('id'=>'designation_id','class'=>'form-control','autofocus')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="department_id" class="col-sm-3 col-form-label text-md-right">Department</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                {!! Form::select('department_id',$departments,null,array('id'=>'department_id','class'=>'form-control','autofocus')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="salary_grade" class="col-sm-3 col-form-label text-md-right">Salary Grade</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="number" name="salary_grade" id="salary_grade" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="provision_salary" class="col-sm-3 col-form-label text-md-right">Provision Salary</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="provision_salary" id="provision_salary" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="regular_salary" class="col-sm-3 col-form-label text-md-right">Regular Salary</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="regular_salary" id="regular_salary" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="responsibility" class="col-sm-3 col-form-label text-md-right">Responsibility</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="responsibility" id="responsibility" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="provision_period" class="col-sm-3 col-form-label text-md-right">Provision Period</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="provision_period" id="provision_period" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="joining_date" class="col-sm-3 col-form-label text-md-right">Joining Date</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="text" name="joining_date" id="joining_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
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
                                <th>Print</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $i=>$row)
                            <tr>
                                <td>{!! $row->issue_number !!}</td>
                                <td>{!! $row->name !!}</td>
                                <td>{!! $row->mobile_no !!}</td>
                                <td>{!! $row->designation->name !!}</td>
                                <td>{!! $row->submission_date !!}</td>
                                <td>
                                <a class="btn btn-info btn-sm" href="{!! url('bioData/print/english/'.$row->id) !!}">English</a>
                                <a class="btn btn-success btn-sm" href="{!! url('bioData/print/bangla/'.$row->id) !!}">Bangla</a>
                            </td>
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