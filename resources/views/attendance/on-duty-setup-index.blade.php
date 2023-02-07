@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">On Duty Setup</h2>
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
                        <form method="post" action="{{ route('attendance/onDutyIndex') }}" >
                            @csrf

                            <input type="hidden" name="to_emp_id" id="to_emp_id" class="form-control">


                            <div class="form-group row">
                                <label for="emp_id" class="col-sm-4 col-form-label text-md-right">ID</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="emp_id" id="emp_id" class="form-control typeahead" required autocomplete="off">
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
                                <label for="duty_place" class="col-sm-4 col-form-label text-md-right">Duty Location</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" name="duty_place" cols="50" rows="4" id="duty_place"></textarea>
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
                    <div class="card-header">Last Inserted Data</div>

                    <form class="form-inline" method="get" action="{{ route('attendance/onDutyIndex') }}">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="search_name" class="sr-only">Search by ID/Name</label>
                            <input type="text" class="form-control typeahead_b" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">
                        </div>

                        {!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}

                        <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-search">Search</i></button>
                    </form>


                    <div class="card-body">
                        <table class="table table-bordered table-responsive table-striped">
                            <thead>
                            <tr>
                                <th width="220px" style="font-weight: bold">Name</th>
                                <th width="80px" style="font-weight: bold">Date</th>
                                <th style="font-weight: bold">Location</th>
                                <th style="font-weight: bold">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i=>$row)
                                <tr>
                                    <td>{!! $row->professional->personal->full_name !!} <br/>{!! $row->professional->employee_id !!}</td>
                                    <td>{!! \Carbon\Carbon::parse($row->from_date)->format('d-m-Y') !!} To {!! \Carbon\Carbon::parse($row->to_date)->format('d-m-Y') !!}</td>
                                    <td>{!! $row->duty_place !!}</td>
                                    <td><button type="submit" id="duty-data-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-duty-delete btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                                    {{--<td><button class="btn btn-secondary btn-ot-delete btn-sm" value="{!! $row->id !!}" type="submit" name="action"> <i class="fa fa-trash"></i>  </button></td>--}}
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


        $(document).on('click', '.form-control.typeahead', function() {

            var autocomplete_path = "{{ url('autocomplete/employeeNameId') }}";

            $(this).typeahead({
                minLength: 1,
                displayText:function (data) {
                    return data.professional.employee_id + " : " + data.full_name;
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

                    $('#to_emp_id').val(data.professional.employee_id);
                    $('#emp_details').html(data.professional.employee_id);

                }

            });
        });



        $(document).on('click', '.form-control.typeahead_b', function() {

            var autocomplete_path = "{{ url('autocomplete/employeeNameId') }}";

            $(this).typeahead({
                minLength: 1,
                displayText:function (data) {
                    return data.professional.employee_id + " : " + data.full_name;
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

                    $('#search_id').val(data.professional.employee_id);

                }

            });
        });





        $(document).on('click', '.btn-duty-delete', function () {
            // e.preventDefault();

            input_id = $(this).attr('id').split('-');
            item_id = parseInt(input_id[input_id.length - 1]);
            var $tr = $(this).closest('tr');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'deleteOnDuty';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    method: '_POST', submit: true, row_id: $('#duty-data-' + item_id).val(),
                },

                error: function (request) {

                    alert(request.responseText);
                },

                success: function (data) {

                    alert(data.success);
                    $tr.find('td').fadeOut(1000,function(){
                        $tr.remove();
                    });
                },

            });

        });


        $(function (){

            $( "#from_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false,
            });

            $( "#to_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false,
            });

            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>

@endpush