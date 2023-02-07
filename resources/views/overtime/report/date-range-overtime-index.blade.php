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

        <div class="row" id="div-select">
            <div class="col-md-6">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}
                    <div class="card-header"> Ovetime</div>
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
                                {!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                          
                                </div>
                            </div>

</br>
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
            <div class="col-md-6">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}
                    <div class="card-header">Approve Or Reject Overtime List</div>
                    <div class="card-body">
                        <form method="get" action="{{ route('overtime/dateRangeApproveRejectReportIndex') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">From OT Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="from1_date" id="from1_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-4 col-form-label text-md-right">To OT Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="to1_date" id="to1_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    {!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control','placeholder'=>'Select Department']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="department_id" class="col-md-4 col-form-label text-md-right"> Overtime Status</label>
                                <div class="col-md-6">
                                    {!! Form::select('status_id',['1'=>'Approve','2'=>'Reject'],null,['id'=>'status_id', 'class'=>'form-control','placeholder'=>'Select Status']) !!}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="summary">Summary</button>
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

            @foreach($dates as $i=>$date)

            @if($data->contains('ot_date',$date))
                <div class="card">

                    <div class="card-header">

                    @if(!empty($dept_data))
                    <h3 style="font-weight: bold">Department Name : {!! $dept_data->name !!}<br/>
                            Report Title: Overtime Setup Report For Date : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>
                @else
                <h3 style="font-weight: bold">
                            Report Title: Overtime All Department Report For Date : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>
                @endif
                        
                    </div>
                    

        <div> OT Date: {!! \Carbon\Carbon::parse($date)->format('d-M-Y') !!}</div>

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
                                <th> Status</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    @if($date == $row->ot_date)
                                        <tr>
                                            <td>{!! $row->employee_id !!}</td>
                                            <td>{!! $row->professional->personal->full_name !!}<br/>{!! $row->professional->department->name !!}</td>
                                            <td>{!! $row->ot_hour !!}</td>
                                            <td>{!! $row->reason !!}</td>
                                            <td>{!! $row->user->name !!}</td>
                                            <td>{!! $row->approver->name ?? '' !!}</td>
                                          
                                                <td>{{$row->approval_status==1 ? "Recomended" : "Apply"}}</td>
                                          

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
            $( "#from1_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });

            $( "#to1_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });

    </script>


@endpush