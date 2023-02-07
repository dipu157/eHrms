@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Attendance Report</h2>
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


        <div class="row" id="div-select">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Detail Attendance</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('attendance/dateRangeReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="from_date" id="from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="to_date" id="to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee ID</label>
                                <div class="col-md-6">
                                    <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Enter ID" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$dept_lists,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-3 text-md-center">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>

                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-info" name="action" value="download">Excel</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Attendance by Status</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('attendance/dateRangeStatusPrint') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="s_from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="s_from_date" id="s_from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="s_to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="s_to_date" id="s_to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Status</label>
                                <div class="col-md-6">
                                    {!! Form::select('status_id',['1'=>'Late','2'=>'Absent','3'=>'Leave','4'=>'Early Exit',],null,['id'=>'status_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee ID</label>
                                <div class="col-md-6">
                                    <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Enter ID" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$dept_lists,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                {{--<div class="col-md-6 offset-md-1">--}}
                                    {{--<button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>--}}
                                {{--</div>--}}
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

            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Department Name : {!! isset($data[0]->department_id) ? $data[0]->department->name : '' !!}<br/>
                        Report Title: Attendance Summary Report. Date from : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} to {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>
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
                            <th>Action</th>

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
                                <td><a href="{!! url('attendance/print/employee/'.$row->employee_id.'/'.$from_date.'/'.$to_date) !!}">
                                        <i class="fa fa-print"></i>
                                    </a></td>
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

            $( "#s_from_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#s_to_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush