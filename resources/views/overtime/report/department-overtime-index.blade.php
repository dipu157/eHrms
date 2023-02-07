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


                            <div class="form-group row mb-0">

                                <div class="col-md-3 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="approve">Approve</button>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <button type="submit" class="btn btn-info" name="action" value="reject">Reject</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


      
        @if(!empty($data1))
        @php($grandtotal = 0)

                <div class="card">
                    <div class="card-header">
                        <h3 style="font-weight: bold">All Department Wise Total Overtime</h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-info table-striped table-bordered">

                            <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Total Overtime</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php($grand_total = 0)

                                @foreach($data1 as $row)
                                    <tr>
                                        <td>{!! $row->name !!}</td>
                                        <td>{!! $row->overtime !!}</td>
                                    </tr>

                            @php($grand_total = $grand_total + $row->overtime ?? 0)
                                @endforeach
                            </tbody>

                            <tfoot>
                                    <tr>
                                        <td style="border-bottom-width:1px; font-weight: bold; font-size:12pt; text-align: left">All Department Grand Total</td>
                                        <td>{!! $grand_total !!}  Hours</td>
                                    </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>            
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