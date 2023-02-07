@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Approve Food Charges For The Month of {!! $period->month_name ?? '' !!}, {!! $period->calender_year ?? ''   !!}</h2>
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

            <div class="col-md-6">
                <div class="pull-right">
                    <a class="btn btn-secondary" href="{!! url('foodBeverages/approveFoodCharge') !!}"> <i class="fa fa-list"></i> Approve </a>
                </div>
            </div>

        </div>


        @if(!is_null($charges))

            <div class="card">
                <div class="card-header">
                    <h3>Food Charges For</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="overflow-x:auto;">
                            <table class="table table-bordered table-hover table-striped" id="roster-table">
                                <thead style="background-color: #b0b0b0">
                                <tr>
                                    <th width="30px">SL</th>
                                    <th width="180px">Name</th>
                                    <th width="180px">Designation</th>
                                    <th width="180px">Description</th>
                                    <th width="80px">Amount</th>
                                    <th width="60px">Status</th>

                                </tr>
                                </thead>
                                <tbody>

                                @php($total = 0)

                                @foreach($charges as $i=>$emp)

                                    <tr>
                                        <td>{!! $i + 1 !!}</td>
                                        <td>{!! $emp['employee_id'] !!} <br/> {!! $emp['name'] !!}</td>
                                        <td>{!! $emp['designation'] !!} <br/>{!! $emp['department'] !!}</td>
                                        <td>{!! $emp['description'] !!}</td>
                                        <td>{!! number_format($emp['amount'],2) !!}</td>
                                        <td>{!! $emp['status'] == 0 ? 'Approved' : '' !!}</td>
                                    </tr>
                                    @php($total = $total + $emp['amount'])
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td>{!! number_format($total,2) !!}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>









    </script>


@endpush