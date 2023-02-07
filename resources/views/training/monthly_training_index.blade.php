@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Training Finalization : {!! $department->name ?? '' !!}</h2>
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
            <div class="col-md-12">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">

                        <form class="form-inline" id="search-form" method="get" action="{{ route('training/finaltraining') }}">

                            <div class="form-group mx-sm-3 mb-1">
                                {!! Form::select('department_id',$departments, null,['id'=>'department_id', 'class'=>'form-control']) !!}
                            </div>



                            <div class="form-group mx-sm-3 mb-1">
                                {!! Form::label('from', 'From', array('class' => 'control-label')) !!}
                                {!! Form::text('from_date', \Carbon\Carbon::now()->format('d-m-Y'),array('id'=>'from_date','class'=>'form-control','autocomplete'=>'off')) !!}
                            </div>

                            <div class="form-group mx-sm-3 mb-1">
                                {!! Form::label('status', 'To', array('class' => 'control-label')) !!}
                            </div>

                            <div class="form-group mx-sm-3 mb-1">
                                {!! Form::text('to_date', \Carbon\Carbon::now()->format('d-m-Y'),array('id'=>'to_date','class'=>'form-control','autocomplete'=>'off')) !!}
                            </div>

                            {{--<div class="form-group mx-sm-3 mb-1">--}}
                                {{--{!! Form::selectMonth('search_month',null,['id' => 'search_month','class'=>'form-control']) !!}--}}
                            {{--</div>--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Submit</button>
                                </div>

                            </div>

                            {{--<button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search">Submit</i></button>--}}
                        </form>




                    </div>
                </div>
            </div>
        </div>

        {{--{!! Form::hidden('r_year', $year, array('id' => 'r_year')) !!}--}}
        {{--{!! Form::hidden('month_id', $month, array('id' => 'month_id')) !!}--}}
        {{--{!! Form::hidden('dept_id', $department_id, array('id' => 'dept_id')) !!}--}}


        @if(!is_null($dateRange))



            @foreach($dateRange as $row)

                @if($data->contains('training_date',$row))


                <div class="card">
                <div class="card-header">
                    <h3>Training Date {!! $row !!} : {!! $department->name ?? '' !!}</h3>
                {{--<h3 style="font-weight: bold">Department Name : {!! isset($data[0]->department_id) ? $data[0]->department->name : '' !!}<br/>--}}
                {{--Report Title: Attendance Summery Report. Date from : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} to {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>--}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="overflow-x:auto;">
                            <table class="table table-bordered table-hover table-striped" id="roster-table">
                                <thead style="background-color: #b0b0b0">
                                <tr>
                                    <th width="15px">SL</th>
                                    <th width="180px">Employee ID</th>
                                    <th width="180px">Name</th>
                                    <th width="125px">Designation</th>
                                    <th width="60px">Training</th>
                                    <th width="60px">Recommended</th>
                                    <th width="155px">Reason</th>
                                    <th width="60px">Action</th>

                                </tr>
                                </thead>
                                @php($count = 1)
                                <tbody>
                                    @foreach($data as $i=>$emp)

                                        @if($row == $emp->training_date)
                                            <tr id="tr-id-{!! $i !!}" style="background-color: {!! $emp->ot_hour <> $emp->calculated_hour ? '#FFDAB9' : '' !!}">
                                                {!! Form::hidden('id', $emp->id, array('id' => 'row_id-'.$i)) !!}
                                                {!! Form::hidden('training_date', $emp->training_date, array('id' => 'training_date-'.$i)) !!}
                                                <td>{!! $count ++ !!}</td>
                                                <td>{!! $emp->employee_id !!} </td>

                                                <td>  {!! $emp->employee->personal->full_name !!}</td>
                                                <td><span style="color: rebeccapurple">{!! $emp->employee->designation->name !!}</span></td>
                                                <td width="180px"> <br/>
                                                 <span style="color: #0062cc">Time {!! \Carbon\Carbon::parse($emp->start_from)->format('g:i A') !!} -- {!! \Carbon\Carbon::parse($emp->end_on)->format('g:i A') !!}-{!! $emp->title !!}</span>
                                                    
                                                    </td>
                                             
                                                <td> <span style="color: #7d0000"> {!! $emp->approver->name ?? '' !!}</span> <br/><span style="color: #7d0000"> {!! $emp->recommended_date ?? '' !!}</span> </td>
                                                <td> {!! $emp->reason !!}br/> </span></td>
                                                <td><button type="submit" id="emp-data-{!! $i !!}" value="{!! $emp->employee_id !!}" class="btn btn-emp-data btn-primary btn-sm">Approve</button><br/>
                                                    <button type="submit" id="emp-reject-{!! $i !!}" value="{!! $emp->employee_id !!}" class="btn btn-emp-reject btn-danger btn-sm">Reject</button></td>
                                            </tr>
                                        @endif

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
                @endif
            @endforeach
        @endif

        @include('overtime.modal.punch-modal')

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>

        $(document).ready(function(){

            $("#from_date" ).datetimepicker({
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


        $(document).ready(function() {

            $(document).on('click', '.btn-emp-data', function () {
                // e.preventDefault();

                input_id = $(this).attr('id').split('-');
                item_id = parseInt(input_id[input_id.length - 1]);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = 'calculate';

                // confirm then
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        method: '_POST', submit: true, employee_id: $('#emp-data-' + item_id).val(),
                        final_hour: $('#final_hour-' + item_id).val(),
                        reject_Reason: $('#reject_Reason-' + item_id).val(),
                        row_id: $('#row_id-' + item_id).val(),
                    },

                    error: function (request) {
                        alert(request.responseText);
                    },

                    success: function (data) {
                        // alert(data.success);
                        $('#tr-id-'+item_id).remove();
                    },

                });

            });





            $(document).on('click', '.btn-emp-reject', function () {
                // e.preventDefault();

                input_id = $(this).attr('id').split('-');
                item_id = parseInt(input_id[input_id.length - 1]);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = 'overtimeReject';

                // confirm then
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        method: '_POST', submit: true, employee_id: $('#emp-data-' + item_id).val(),
                        final_hour: $('#final_hour-' + item_id).val(),
                        reject_Reason: $('#reject_Reason-' + item_id).val(),
                        
                        row_id: $('#row_id-' + item_id).val(),
                    },

                    error: function (request) {
                        alert(request.responseText);
                    },

                    success: function (data) {
                        // alert(data.success);
                        $('#tr-id-'+item_id).remove();
                    },

                });

            });









            $(document).on('click', '.btn-emp-punch', function () {
                // e.preventDefault();

                input_id = $(this).attr('id').split('-');
                item_id = parseInt(input_id[input_id.length - 1]);
                $("#new-row").remove();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = 'getPunchData';

                // confirm then
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',

                    data: {
                        method: '_GET', submit: true, employee_id: $('#emp-punch-' + item_id).val(),
                        punch_date: $('#punch_date-' + item_id).val(),
                    },

                    error: function (request) {
                        alert(request.responseText);
                    },

                    success: function (response) {

                        // $('#new-row').remove();
                        $(".new-row").remove();

                        var trHTML = '';

                        $.each(response, function (i, item) {
                            trHTML += '<tr class="new-row"><td>' + item.punch_dt + '</td></tr>';
                        });
                        $('#punch_table').append(trHTML);

                        $('#punchInfoModalSuccess').modal('show')
                    },

                });

            });


        });




        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });


    </script>


@endpush