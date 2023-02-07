@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Roster Data For <strong style="color: #980000">{!! \Illuminate\Support\Facades\Session::get('session_user_dept_name') !!} </strong> Department</h2>
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

                        <form class="form-inline" id="search-form" method="get" action="{{ route('roster/printRosterIndex') }}">

                            <div class="form-group mb-1 col-3">
                                {!! Form::select('department_id',$departments, $department_id,['id'=>'department_id', 'class'=>'form-control']) !!}
                            </div>

                            <div class="form-group mb-1 mx-sm-1 col-1">
                                {!! Form::selectYear('search_year', 2019, 2025,2019,array('id'=>'search_year','class'=>'form-control')) !!}
                            </div>

                            <div class="form-group mb-1 col-1">
                                {!! Form::selectMonth('search_month',$month,['id' => 'search_month','class'=>'form-control']) !!}
                            </div>

                            <div class="form-group mb-1 col-2">
                                {!! Form::select('location_id',$locations, null,['id' => 'location_id','class'=>'form-control','placeholder'=>'Location']) !!}
                            </div>
                            <div class="form-group mb-1 col-3">
                                {!! Form::select('section_id',$sections, null,['id' => 'section_id','class'=>'form-control','placeholder'=>'section']) !!}
                            </div>
                            <div class="form-group row mb-0 col-1">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary btn-sm" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 mx-sm-1 text-md-right">
                                    <button type="submit" class="btn btn-secondary btn-sm" name="action" value="print">Print</button>
                                </div>
                            </div>

                            {{--<button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search">Submit</i></button>--}}
                        </form>




                    </div>
                </div>
            </div>
        </div>

        {!! Form::hidden('r_year', $year, array('id' => 'r_year')) !!}
        {!! Form::hidden('month_id', $month, array('id' => 'month_id')) !!}
        {!! Form::hidden('dept_id', $department_id, array('id' => 'dept_id')) !!}


        @if(!is_null($year))



            {{--@foreach($departments as $dept)--}}
            <div class="card">
                {{--<div class="card-header">--}}
                    {{--<h3 style="font-weight: bold">Department Name : {!! isset($data[0]->department_id) ? $data[0]->department->name : '' !!}<br/>--}}
                        {{--Report Title: Attendance Summery Report. Date from : {!! \Carbon\Carbon::parse($from_date)->format('d-M-Y') !!} to {!! \Carbon\Carbon::parse($to_date)->format('d-M-Y') !!}</h3>--}}
                {{--</div>--}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="overflow-x:auto;">
                            <table class="table table-bordered table-hover table-striped" id="roster-table">
                                <thead style="background-color: #b0b0b0">
                                <tr>
                                    <th>Name</th>
                                    <th>Day 01</th>
                                    <th>Day 02</th>
                                    <th>Day 03</th>
                                    <th>Day 04</th>
                                    <th>Day 05</th>
                                    <th>Day 06</th>
                                    <th>Day 07</th>
                                    <th>Day 08</th>
                                    <th>Day 09</th>
                                    <th>Day 10</th>
                                    <th>Day 11</th>
                                    <th>Day 12</th>
                                    <th>Day 13</th>
                                    <th>Day 14</th>
                                    <th>Day 15</th>
                                    <th>Day 16</th>
                                    <th>Day 17</th>
                                    <th>Day 18</th>
                                    <th>Day 19</th>
                                    <th>Day 20</th>
                                    <th>Day 21</th>
                                    <th>Day 22</th>
                                    <th>Day 23</th>
                                    <th>Day 24</th>
                                    <th>Day 25</th>
                                    <th>Day 26</th>
                                    <th>Day 27</th>
                                    <th>Day 28</th>
                                    <th>Day 29</th>
                                    <th>Day 30</th>
                                    <th>Day 31</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{--@endforeach--}}
        @endif

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>

        $(function() {
            var table= $('#roster-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'rosterDataTable/' + $('#r_year').val() + '/' + $('#month_id').val() + '/' + $('#dept_id').val(),
                columns: [
                    { data: 'employee', name: 'employee' },
                    { data: 'day_01', name: 'day_01' },
                    { data: 'day_02', name: 'day_02' },
                    { data: 'day_03', name: 'day_03' },
                    { data: 'day_04', name: 'day_04' },
                    { data: 'day_05', name: 'day_05' },
                    { data: 'day_06', name: 'day_06' },
                    { data: 'day_07', name: 'day_07' },
                    { data: 'day_08', name: 'day_08' },
                    { data: 'day_09', name: 'day_09' },
                    { data: 'day_10', name: 'day_10' },
                    { data: 'day_11', name: 'day_11' },
                    { data: 'day_12', name: 'day_12' },
                    { data: 'day_13', name: 'day_13' },
                    { data: 'day_14', name: 'day_14' },
                    { data: 'day_15', name: 'day_15' },
                    { data: 'day_16', name: 'day_16' },
                    { data: 'day_17', name: 'day_17' },
                    { data: 'day_18', name: 'day_18' },
                    { data: 'day_19', name: 'day_19' },
                    { data: 'day_20', name: 'day_20' },
                    { data: 'day_21', name: 'day_21' },
                    { data: 'day_22', name: 'day_22' },
                    { data: 'day_23', name: 'day_23' },
                    { data: 'day_24', name: 'day_24' },
                    { data: 'day_25', name: 'day_25' },
                    { data: 'day_26', name: 'day_26' },
                    { data: 'day_27', name: 'day_27' },
                    { data: 'day_28', name: 'day_28' },
                    { data: 'day_29', name: 'day_29' },
                    { data: 'day_30', name: 'day_30' },
                    { data: 'day_31', name: 'day_31' },
                    { data: 'location', name: 'location' },
                    { data: 'status', name: 'status' },
                ]
            });

        });


    </script>


@endpush