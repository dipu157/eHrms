@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Division Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    {{--<link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />--}}
    {{--<script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>--}}
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>
    </div> <!--/.Container-->



    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{--<div class="card-header">User Privillege</div>--}}

                <div class="card-body">
                    <form method="get" action="{!! url('leave/applyIndex') !!}" >
                        @csrf

                        <div class="form-group row" id="person_name">
                            <label for="name" id="label_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control typeahead" name="name" value="" required autocomplete="off">
                                <input id="emp_id" type="hidden" id="emp_id" class="form-control" name="emp_id" required>
                            </div>
                        </div>


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

    @if(!empty($emp_info))



        <div class="container-fluid">
            <div  class="panel panel-default thumbnail">

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center"><img src="{!! isset($emp_info->photo) ? asset($emp_info->photo) : ($emp_info->gender == 'M' ? asset('assets/images/male.jpeg') : asset('assets/images/female.png'))  !!}" width="200px" height="200px" class="img-rounded img-responsive" alt="..">
                            <br/>
                            <h3 style="font-weight: bold">{!!$emp_info->full_name !!}<br/>
                                {!!$emp_info->professional->designation->name !!}<br/>
                                {!!isset($emp_info->professional->department_id) ? $emp_info->professional->department->name : '' !!}
                            </h3>

                        </div>

                        <div class=" col-md-9 col-lg-9 ">

                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>Title:</td>
                                    <td>{!! $emp_info->title->name !!}</td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td>{!! $emp_info->full_name !!}</td>
                                </tr>

                                <tr>
                                    <td>Email:</td>
                                    <td>{!! $emp_info->email !!}</td>
                                </tr>

                                <tr>
                                    <td>Joining Date:</td>
                                    <td>{!! \Carbon\Carbon::parse($emp_info->professional->joining_date)->format('d-M-Y') !!}</td>
                                </tr>

                                <tr>
                                    <td>Blood Group:</td>
                                    <td>{!! $emp_info->blood_group !!}</td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div> <!--/.Container-->

{{--APPLICATION--}}

        <div class="card text-center bg-light mb-3" style="width: 50rem;">
            <div class="card-header">
                Apply for Leave
            </div>
            <div class="card-body">
                <form action="{!! url('leave/application/save') !!}" id="leave-application-form"  method="post" accept-charset="utf-8">
                    {{ csrf_field() }}

                    <input id="emp_id" type="hidden" value="{!! $emp_info->id !!}" class="form-control" name="emp_id" required>

                    <div class="form-group row">
                        <label for="leave_id" class="col-sm-4 col-form-label text-md-right">Leave Type</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                {!! Form::select('leave_id',$leaves,null,array('id'=>'leave_id','class'=>'form-control')) !!}
                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="duty_div">
                        <label for="duty_date" class="col-sm-4 col-form-label text-md-right text-red">Duty Date</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="duty_date" id="duty_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="from_date" class="col-sm-4 col-form-label text-md-right">Start From</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="from_date" id="from_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="to_date" class="col-sm-4 col-form-label text-md-right">To Date</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="to_date" id="to_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reason" class="col-sm-4 col-form-label text-md-right">Reason</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="reason" cols="50" rows="4" id="reason"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="location" class="col-sm-4 col-form-label text-md-right">Location & Mobile</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="location" id="location" class="form-control" required autocomplete="off" placeholder="Location & Mobile No">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="alternate" class="col-sm-4 col-form-label text-md-right">Select Alternate</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="alternate" id="alternate" class="form-control typeahead-alter" required autocomplete="off" placeholder="Write ID the select from dropdown">
                            </div>
                        </div>
                    </div>

                    <input id="alternate_id" type="hidden" class="form-control" name="alternate_id">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>



        <div class="row">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Current Year Leave History
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>Application <br/>Date</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Print</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emp_info->leaveStatus as $row)
                                <tr>
                                    <td>{!! \Carbon\Carbon::parse($row->created_at)->format('d-M-Y') !!}</td>
                                    <td>{!! $row->type->name !!}</td>
                                    <td>{!! $row->from_date !!}</td>
                                    <td>{!! $row->to_date !!}</td>
                                    <td>{!! $row->reason !!}</td>
                                    <td>{!! $row->status == 'D' ? 'Rejected' : ($row->status == 'C' ? 'Applied' : ($row->status == 'R' ? 'Recommended' : ($row->status == 'K' ? 'Acknowledged' : ($row->status == 'A' ? 'Approved' : 'Canceled')))) !!}</td>
                                    <td><a href="{!! $row->status == 'A' ? url('employee/leave/print/'.$row->id) : '#' !!}"><i class="fa fa-print"></i></a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <br/>


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Leave Statistics
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">

                            <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Total Leave</th>
                                <th>Enjoyed</th>
                                <th>Balance</th>
                                <th>Last Leave</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($emp_info->leave as $row)
                                <tr>
                                    <td>{!! $row->type->name !!}</td>
                                    <td>{!! $row->leave_eligible !!}</td>
                                    <td>{!! $row->leave_enjoyed !!}</td>
                                    <td>{!! $row->leave_balance !!}</td>
                                    <td>{!! $row->last_leave !!}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    @endif



@endsection

@push('scripts')

    <script>

        var autocomplete_path = "{{ url('autocomplete/departmentEmployee') }}";

        $(document).on('click', '.form-control.typeahead', function() {

            $(this).typeahead({
                minLength: 2,
                displayText:function (data) {
                    return data.professional.employee_id + ' : '+ data.full_name;
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

                    document.getElementById('emp_id').value = data.id;
                }
            });
        });





        $(document).on('click', '.form-control.typeahead-alter', function() {

            $(this).typeahead({
                minLength: 2,
                displayText:function (data) {
                    return data.professional.employee_id + ' : '+ data.full_name;
                },

                source: function (query, process) {
                    $.ajax({
                        url: "{{ url('autocomplete/employeeNameId') }}",
                        type: 'GET',
                        dataType: 'JSON',
                        data: 'query=' + query ,
                        success: function(data) {
                            return process(data);
                        }
                    });
                },
                afterSelect: function (data) {

                    document.getElementById('alternate_id').value = data.professional.employee_id;
                }
            });
        });




        $( function() {

            $("#duty_div").hide();

            $('#leave_id').change(function(){

                $(this).val() == 3 ? $("#duty_div").show() : $("#duty_div").hide();
            });


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

            $( "#duty_date" ).datetimepicker({
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