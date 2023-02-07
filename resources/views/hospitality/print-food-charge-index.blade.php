@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Print Preview Food Charges</h2>
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
            <div class="col-md-6">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">

                        <form class="form-inline" id="search-form" method="get" action="{{ route('foodBeverages/printFoodChargeIndex') }}">


                            <div class="form-group mx-sm-3 mb-1">
                                {!! Form::selectYear('search_year', 2019, 2025,2019,array('id'=>'search_year','class'=>'form-control')) !!}
                            </div>

                            {!! Form::hidden('search_new', 1, array('id' => 'search_new')) !!}

                            <div class="form-group mx-sm-3 mb-1">
                                {!! Form::selectMonth('search_month',5,['id' => 'search_month','class'=>'form-control']) !!}
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 pull-left">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Submit</button>
                                </div>
                                <div class="col-md-6 pull-right">
                                    <button type="submit" class="btn btn-info" name="action" value="print">Print</button>
                                </div>

                            </div>

                        </form>




                    </div>
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
                                @foreach($charges as $i=>$emp)

                                    <tr>
                                        <td>{!! $i + 1 !!}</td>
                                        <td>{!! $emp['employee_id'] !!} <br/> {!! $emp['name'] !!}</td>
                                        <td>{!! $emp['designation'] !!} <br/>{!! $emp['department'] !!}</td>
                                        <td>{!! $emp['description'] !!}</td>
                                        <td>{!! number_format($emp['amount'],2) !!}</td>
                                        <td>{!! $emp['status'] == 0 ? 'Approved' : '' !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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