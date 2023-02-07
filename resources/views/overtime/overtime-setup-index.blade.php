@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Overtime Setup :</h2>
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
                        <form method="post" action="{{ route('overtime/overtimePost') }}" >
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
                                <label for="ot_type" class="col-md-4 col-form-label text-md-right">Type</label>

                                <div class="col-md-8">

                                    {!! Form::select('ot_type',['S'=>'OT Scheduled Duty','O'=>'Off day','H'=>'Public Holiday'],null,['id'=>'ot_type', 'class'=>'form-control']) !!}

                                </div>
                            </div>

                            {{--<div class="form-group row">--}}
                                {{--<label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--{!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control']) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            <div class="form-group row">
                                <label for="ot_date" class="col-md-4 col-form-label text-md-right">Select Date</label>

                                <div class="col-md-8">

                                    <input type="text" name="ot_date" id="ot_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entry_time" class="col-sm-4 col-form-label text-md-right">Entry Time</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="entry_time" id="entry_time" class="form-control" readonly autocomplete="off">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="exit_time" class="col-sm-4 col-form-label text-md-right">Exit Time</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="exit_time" id="exit_time" class="form-control" readonly autocomplete="off">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="ot_hour" class="col-sm-4 col-form-label text-md-right">Over Time Hour</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="ot_hour" id="ot_hour" class="form-control" required autocomplete="off">
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
                    <div class="card-header">This Month Overtime</div>

                


                    <div class="card-body">
                    
                        <table class="table table-bordered  table-responsive" id=
                        'abc'>
                            <thead>
                                <tr>
                                    <th width="120px" style="font-weight: bold">Date</th>
                                    <th width="220px" style="font-weight: bold">Name</th>
                                    <th style="font-weight: bold">Hour</th>
                                    <th style="font-weight: bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $i=>$row)
                                    <tr>
                                        <td>{!! $row->ot_date !!}<br/>{!! \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!} - {!! \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!}</td>
                                        <td>{!! $row->professional->personal->full_name !!}</td>
                                        <td>{!! $row->ot_hour !!}</td>
                                        <td><button type="submit" id="overtime-data-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-overtime-delete btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
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

$(document).ready( function () {
    $('#abc').DataTable();
} );


        $(document).on('click', '.form-control.typeahead', function() {

            var autocomplete_path = "{{ url('autocomplete/departmentEmployee') }}";

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

            var autocomplete_path = "{{ url('autocomplete/departmentEmployee') }}";

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





        $(document).on('click', '.btn-overtime-delete', function () {
            // e.preventDefault();

            input_id = $(this).attr('id').split('-');
            item_id = parseInt(input_id[input_id.length - 1]);
            var $tr = $(this).closest('tr');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'deleteOvertime';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    method: '_POST', submit: true, row_id: $('#overtime-data-' + item_id).val(),
                },

                error: function (request) {

                    alert(request.responseText);
                },

                success: function (data) {

                    alert(data.success);
                    $tr.find('td').fadeOut(1000,function(){
                        $tr.remove();
                    });
                    // $('#status-' + item_id).html('Cancelled');
                },

            });

        });





        $(document).ready(function(){

            var currentTime = new Date();
            // First Date Of the current month
            // var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);

            // specific  Date Of the current month
            // var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);
           

        
        var startDateFrom = new Date(new Date().setDate(currentTime.getDate() - 35));
            // from first day of previous month
         //var startDateFrom = new Date(currentTime.getFullYear(),currentTime.getMonth()-1,15);

            // Last Date Of the Month
            var startDateTo = new Date(currentTime.getFullYear(),currentTime.getMonth() +1,0);


            $( "#ot_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false,
                minDate: startDateFrom,
            });


            $( "#entry_time" ).datetimepicker({
                format:'H:i',
                datepicker:false,
                closeOnTimeSelect:true,
                inline:false,
                step:30
            });

            $( "#exit_time" ).datetimepicker({
                format:'d-m-Y H:i',
                closeOnTimeSelect:true,
                inline:false,
                step:30
                // step:15,
                // onSelectTime: function () {
                //     document.getElementById('duty_hour').value = document.getElementById('from_time').value - document.getElementById('to_time').value;
                // }
            });

        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        idleTimer();

    </script>

@endpush