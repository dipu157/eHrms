@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Update Leave Information</h2>
    <h2 class="no-margin-bottom" id="emp_details" style="color: red"></h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


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
                        <form method="get" action="{{ route('leave/updateIndex') }}" >
                            @csrf

                            <input type="hidden" name="to_id" id="to_id" class="form-control">

                            <div class="form-group row">
                                <label for="emp_id" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="emp_id" id="emp_id" class="form-control typeahead" required autocomplete="off">
                                    </div>
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
                                    ID: {!!$emp_info->professional->employee_id !!}<br/>
                                    {!!$emp_info->professional->designation->name !!}<br/>
                                    {!!isset($emp_info->professional->department_id) ? $emp_info->professional->department->name : '' !!}
                                </h3>

                            </div>

                            <input type="hidden" name="employee_personal_id" id="employee_personal_id" value="{!! $emp_info->id !!}" class="form-control">

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


            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-header">
                            Leave Statistics for the year {!! $c_year !!}
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Leave Type</th>
                                    <th>Leave Year</th>
                                    <th>Total Leave</th>
                                    <th>Enjoyed</th>
                                    <th>Balance</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($emp_info->leave as $row)
                                    <tr>
                                        <input type="hidden" name="reg_leave_id" id="reg_leave_id" value="{!! $row->type->id !!}" class="form-control">
                                        <td>{!! $row->type->id !!}</td>
                                        <td>{!! $row->type->name !!}</td>
                                        <td>{!! $row->leave_year !!}</td>
                                        <td>{!! Form::text('reg_leave_eligible[]',$row->leave_eligible,array('id'=>'reg_leave_eligible','class'=>'form-control')) !!}</td>
                                        <td>{!! $row->leave_enjoyed !!}</td>
                                        <td>{!! $row->leave_balance !!}</td>
                                        <td><button type="submit" name="button_one" id="leave-register" class="btn btn-leave-register btn-primary btn-sm">Update</button></td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Leave Statistics for the year {!! $c_year-1 !!}
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Leave Type</th>
                                    <th>Leave Year</th>
                                    <th>Total Leave</th>
                                    <th>Enjoyed</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($emp_info_lastYear->leave as $row)
                                    <tr>
                                        <input type="hidden" name="reg_leave_id" id="reg_leave_id" value="{!! $row->type->id !!}" class="form-control">
                                        <td>{!! $row->type->id !!}</td>
                                        <td>{!! $row->type->name !!}</td>
                                        <td>{!! $row->leave_year !!}</td>
                                        <td>{!! Form::text('reg_leave_eligible[]',$row->leave_eligible,array('id'=>'reg_leave_eligible','class'=>'form-control')) !!}</td>
                                        <td>{!! $row->leave_enjoyed !!}</td>
                                        <td>{!! $row->leave_balance !!}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @include('leave.modals.add-leave-application')

        @if(!empty($leave_apps))
            <div class="row">
                <div class="col-sm-10">
                    <div class="card">
                        <div class="card-header">
                            Current Year Leave History

                            <a class="btn btn-primary btn-sm btn-add-leave-app"> <i class="fa fa-plus"></i> New </a>

                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped" id="application-table">

                                <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Leave Year</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($leave_apps as $i=>$row)
                                    <tr>
                                        <td>{!! $row->type->name !!} <br> {!! $row->leave_id == 3 ? $row->duty_date : null !!}</td>
                                        <td>{!! $row->leave_year !!}</td>
                                        <td>{!! $row->from_date !!}</td>
                                        <td>{!! $row->to_date !!}</td>
                                        <td>{!! $row->reason !!}</td>
                                        <td id="status-{!! $i !!}">{!! $row->status == 'D' ? 'Rejected' : ($row->status == 'C' ? 'Applied' : ($row->status == 'R' ? 'Recommended' : ($row->status == 'K' ? 'Acknowledged' : ($row->status == 'L' ? 'Cancelled' : 'Approved')))) !!}</td>
                                        <td><button type="submit" id="leave-data-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-leave-cancel btn-danger btn-sm">Cancel</button></td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Last Year Leave History

                            <a class="btn btn-primary btn-sm btn-add-leave-app"> <i class="fa fa-plus"></i> New </a>

                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-striped" id="application-table">

                                <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Leave Year</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($leave_apps_lastYear as $i=>$row)
                                    <tr>
                                        <td>{!! $row->type->name !!} <br> {!! $row->leave_id == 3 ? $row->duty_date : null !!}</td>
                                        <td>{!! $row->leave_year !!}</td>
                                        <td>{!! $row->from_date !!}</td>
                                        <td>{!! $row->to_date !!}</td>
                                        <td>{!! $row->reason !!}</td>
                                        <td id="status-{!! $i !!}">{!! $row->status == 'D' ? 'Rejected' : ($row->status == 'C' ? 'Applied' : ($row->status == 'R' ? 'Recommended' : ($row->status == 'K' ? 'Acknowledged' : ($row->status == 'L' ? 'Cancelled' : 'Approved')))) !!}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>


        $(document).on('click', '.form-control.typeahead', function() {

            $(this).typeahead({
                minLength: 1,
                displayText:function (data) {
                    return data.full_name + ' : ' + data.professional.employee_id;
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
                    $('#to_id').val(data.id);
                    $('#emp_details').html('ID: '+ data.professional.employee_id );
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


        $(document).on('click', '.btn-leave-register', function() {
            // e.preventDefault();

            var $row = $(this).closest("tr"),
            $td2 = $row.find("td:nth-child(2)"),
            $leaveId = $td2.text(),
            $eligible = $row.find("[name='reg_leave_eligible[]']").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'register/update';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {method: '_POST', submit: true,
                    employee_id:$('#employee_personal_id').val(),
                    leave_id:$leaveId,
                    eligible:$eligible,

                },

                error: function (request) {
                    alert(request.responseText);
                },

                success: function (data) {

                    alert('Employee Leave Register Updated');
                    $row.find("td:nth-child(6)").html(data.balance)
                },

            });
        });


        $(document).on('click', '.btn-leave-cancel', function () {
            // e.preventDefault();

            input_id = $(this).attr('id').split('-');
            item_id = parseInt(input_id[input_id.length - 1]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'cancel';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    method: '_POST', submit: true, row_id: $('#leave-data-' + item_id).val(),
                },

                error: function (request) {

                    alert(request.responseText);
                },

                success: function (data) {

                    alert(data.success);
                    $('#status-' + item_id).html('Cancelled');
                },

            });

        });

        $(document).on('click', '.btn-add-leave-app', function() {

            $('#modal-new-leave-app').modal('show')
        });


        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>
@endpush