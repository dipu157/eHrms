@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Overtime Information</h2>
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
            <div class="col-md-8">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">
                        <form method="get" action="{{ route('overtime/dateRangeReportIndex') }}" >
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
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-3 text-md-center">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>

                                <div class="col-md-4 text-md-right">
                                    <button type="submit" class="btn btn-info" name="action" value="excel">Excel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(!empty($data))

            {{--{!! Form::open(['method'=>'get']) !!}--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-7 form-group">--}}
                    {{--<div class="input-group">--}}
                        {{--<input class="form-control" id="search"--}}
                               {{--value="{{ request('search') }}"--}}
                               {{--placeholder="Search name" name="search"--}}
                               {{--type="text" id="search"/>--}}

                        {{--<button type="submit" class="btn btn-primary mb-2">Search</button>--}}

                        {{--<input type="hidden" value="{!! $from_date !!}" name="from_date"/>--}}
                        {{--<input type="hidden" value="{!! $to_date !!}" name="to_date"/>--}}
                        {{--<div class="input-group-btn">--}}
                        {{--<button type="submit" class="btn btn-warning">--}}
                        {{--Search--}}
                        {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--{!! Form::close() !!}--}}



            @foreach($dates as $i=>$date)

            @if($data->contains('ot_date',$date))
                <div class="card">

                    <div class="card-header">
                        <h3 style="font-weight: bold">Department Name : {!! $dept_data->name !!}<br/>
                            Report Title: Overtime Setup Report For Date : {!! \Carbon\Carbon::parse($date)->format('d-M-Y') !!}</h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-info table-striped table-bordered">

                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Hour</th>
                                <th>Reason</th>
                                <th>Entered By</th>
                                <th>Recommand By</th>
                                <th>Approval Status</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    @if($date == $row->ot_date)
                                        <tr>
                                            <td>{!! $row->employee_id !!}</td>
                                            <td>{!! $row->professional->personal->full_name !!}</td>
                                            <td>{!! $row->ot_hour !!}</td>
                                            <td>{!! $row->reason !!}</td>
                                            <td>{!! $row->user->name !!}</td>
                                            <td>{!! $row->approver->name ?? '' !!}</td>
                                            <td>{{$row->status==1 ? "Approve" : "Reject"}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @endforeach
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
        });

    </script>


@endpush