@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">OT Setup</h2>
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


        <div class="row justify-content-left">
            <div class="col-md-5">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">
                        <form method="post" action="{{ route('ot/otSetupPost') }}" >
                            @csrf

                            <input type="hidden" name="to_emp_id" id="to_emp_id" class="form-control">

                            <div class="form-group row">
                                <label for="ot_number" class="col-sm-4 col-form-label text-md-right">UHID</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="ot_number" id="ot_number" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="patient_name" class="col-sm-4 col-form-label text-md-right">Patient Name</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="patient_name" id="patient_name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_name" class="col-sm-4 col-form-label text-md-right">Doctor Name</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="doctor_name" id="doctor_name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-md-right">Description</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" name="description" cols="50" rows="4" id="description"></textarea>
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


            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Recent OT List</div>

                    <div class="card-body">
                        <table class="table table-bordered table-responsive table-striped">
                            <thead>
                            <tr>
                                <th width="60px" style="font-weight: bold">UHID</th>
                                <th width="200px" style="font-weight: bold">Patient Name</th>
                                <th width="200px" style="font-weight: bold">Doctor Name</th>
                                <th width="200px" style="font-weight: bold">OT Status</th>
                                <th style="font-weight: bold">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i=>$row)
                                <tr>
                                    <td>{!! $row->ot_number !!} </td>
                                    <td>{!! $row->patient_name !!} </td>
                                    <td>{!! $row->doctor_name !!}</td>
                                    <td>{!! $row->ot_status == 'P' ? '...' : ($row->ot_status == "C" ? "OT Done, You Will be call soon" : 'Continue') !!}</td>                       
                                    

                                    <td><button type="submit" id="ot-data-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-ot-start btn-success btn-sm">Start OT</button>
                                    <button type="submit" id="ot-data-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-ot-call btn-info btn-sm">Call Attendent</button>
                                    <button type="submit" id="ot-data-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-ot-complete btn-danger btn-sm">OT Completed</button></td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


        </div>

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>


        $(document).on('click', '.btn-ot-start', function () {
            // e.preventDefault();

            input_id = $(this).attr('id').split('-');
            item_id = parseInt(input_id[input_id.length - 1]);
            var $tr = $(this).closest('tr');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'otStatusChange';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    method: '_POST', 
                    submit: true, 
                    row_id: $('#ot-data-' + item_id).val(),
                    ot_status: 'O',
                },

                error: function (request) {

                    alert(request.responseText);
                },

                success: function (data) {

                    alert(data.success);
                    location.reload(true);
                },

            });

        });

         $(document).on('click', '.btn-ot-call', function () {
            // e.preventDefault();

            input_id = $(this).attr('id').split('-');
            item_id = parseInt(input_id[input_id.length - 1]);
            var $tr = $(this).closest('tr');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'otAttendentCall';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    method: '_POST', 
                    submit: true, 
                    row_id: $('#ot-data-' + item_id).val(),
                    ot_status: 'C',
                },

                error: function (request) {

                    alert(request.responseText);
                },

                success: function (data) {

                    alert(data.success);
                    location.reload(true);
                },

            });

        });

        $(document).on('click', '.btn-ot-complete', function () {
            // e.preventDefault();

            input_id = $(this).attr('id').split('-');
            item_id = parseInt(input_id[input_id.length - 1]);
            var $tr = $(this).closest('tr');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'otComplete';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    method: '_POST', 
                    submit: true, 
                    row_id: $('#ot-data-' + item_id).val(),
                    status: 0,
                },

                error: function (request) {

                    alert(request.responseText);
                },

                success: function (data) {

                    alert(data.success);
                    location.reload(true);
                },

            });

        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>

@endpush