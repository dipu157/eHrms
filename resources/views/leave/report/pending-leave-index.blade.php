@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Leave Application Status</h2>
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

        @if(!empty($data))
        @php($off = 0 )
        @foreach($departments as $dept)

            <div class="card">
                <div class="card-header">
                    <h3 style="font-weight: bold">Department Name : {!! $dept->professional->department->name !!}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-secondary table-striped">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $i=>$row)
                            @if($row->professional->department_id == $dept->professional->department_id)
                                @php($off++)
                                <tr>
                                    <td>{!! $off !!}</td>
                                    <td>{!! $row->professional->employee_id !!}</td>
                                    <td>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! \Carbon\Carbon::parse($row->from_date)->format('d-m-Y') !!} To {!! \Carbon\Carbon::parse($row->to_date)->format('d-m-Y') !!}</td>
                                    <td>{!! $row->status == 'C' ? 'Applied' : ($row->status == 'K' ? 'Acknowledged' : 'Recommended') !!}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
        @endif

    </div> <!--/.Container-->

@endsection