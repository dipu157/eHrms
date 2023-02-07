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
                        <form method="get" action="{{ route('overtime/employeeOvertimeIndex') }}" >
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
                                    {!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success" name="action" value="excel">Excel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(!empty($data))
            @php($grandtotal = 0)
            @foreach($employees as $i=>$emp)

                @if($data->contains('employee_id',$emp->employee_id))
                    <div class="card">

                        <div class="card-header">
                            <h3 style="font-weight: bold">Department Name : {!! $emp->professional->personal->full_name !!}<br/>
                                Report Title: Overtime Report For Date From: {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} To {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>
                        </div>
                        <div class="card-body">

                            <table class="table table-info table-striped table-bordered">

                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Hour</th>
                                    <th>Reason</th>
                                    <th>Entered By</th>
                                    <th>Approved By</th>
                                    <th>Finalise By</th>

                                </tr>
                                </thead>
                                <tbody>
                                @php($count = 1)
                                @php($subtotal = 0)

                                @foreach($data as $row)
                                    @if($emp->employee_id == $row->employee_id)
                                        <tr>
                                            <td>{!! $count !!}</td>
                                            <td>{!! $row->ot_date !!}</td>
                                            <td>{!! $row->ot_hour !!}</td>
                                            <td>{!! $row->reason !!}</td>
                                            <td>{!! $row->user->name !!}</td>
                                            <td>{!! $row->approver->name ?? '' !!}</td>
                                            <td>{!! $row->finalize_by ?? '' !!}</td>
                                        </tr>
                                        @php($count++)
                                        @php($subtotal = $subtotal + $row->ot_hour)
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Employee Total</td>
                                        <td colspan="2">{!! $subtotal !!} Hours</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endif

                @php($grandtotal = $grandtotal + $subtotal)
            @endforeach
            <div>Department Grand Total : {!! $grandtotal !!} Hours</div>
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