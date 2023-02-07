@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Attendance Process</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


        <div class="row justify-content-center" id="div-select">
            <div class="col-md-8">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/empProfileIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee</label>
                                <div class="col-md-6">
                                    <input type="text" name="employee_id" id="employee_id" class="form-control typeahead" value="" required autocomplete="off" />
                                </div>
                            </div>

                            <input type="hidden" name="personal_id" id="personal_id" class="form-control">

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(!empty($data))

            {!! Form::open(['method'=>'get']) !!}
            <div class="row">
                <div class="col-sm-7 form-group">
                    <div class="input-group">
                        <input class="form-control" id="search"
                               value="{{ request('search') }}"
                               placeholder="Search name" name="search"
                               type="text" id="search"/>

                        <button type="submit" class="btn btn-primary mb-2">Search</button>

                        <input type="hidden" value="{!! $from_date !!}" name="from_date"/>
                        <input type="hidden" value="{!! $to_date !!}" name="to_date"/>
                        {{--<div class="input-group-btn">--}}
                        {{--<button type="submit" class="btn btn-warning">--}}
                        {{--Search--}}
                        {{--</button>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}


            {{--@foreach($departments as $dept)--}}
            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Department Name : {!! isset($data[0]->department_id) ? $data[0]->department->name : '' !!}<br/>
                        Report Title: Attendance Summery Report. Date from : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} to {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>
                </div>
                <div class="card-body">

                    <table class="table table-info table-striped table-bordered">

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <td>Total</td>
                            <th>Present</th>
                            <th>Off Day</th>
                            <th>In Leave</th>
                            <th>Public Holiday</th>
                            <th>Late</th>
                            <th>Overtime</th>
                            <th>Absent</th>

                        </tr>
                        </thead>
                        <tbody>


                        @foreach($data as $i=>$row)

                            {{--@if($dept->id == $row->department_id)--}}
                            <tr>
                                <td><a href="{!! url('attendance/report/employee/'.$row->employee_id.'/'.$from_date.'/'.$to_date) !!}">
                                        {!! $row->employee_id !!}
                                    </a></td>
                                <td>{!! $row->professional->personal->full_name !!}</td>
                                <td>{!! dateDifference($from_date, $to_date) + 1 !!}</td>
                                <td>{!! $row->present !!}</td>
                                <td>{!! $row->offday !!}</td>
                                <td>{!! $row->n_leave !!}</td>
                                <td>{!! $row->holiday !!}</td>
                                <td>{!! $row->late_count !!}</td>
                                <td>{!! $row->overtime_hour !!}</td>
                                <td>{!! $row->absent !!}</td>
                            </tr>
                            {{--@endif--}}
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
            {{--@endforeach--}}
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
                    $('#personal_id').val(data.id);
                }

            });
        });

        $(document).ready(function(){

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
        });

    </script>


@endpush