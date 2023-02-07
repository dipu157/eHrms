@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Approve Roster For All    <strong style="text-align: right; color: rgba(255,0,0,0.31);">Year : {!! $year !!} Month: {!! $month !!}</strong> </h2>
    <h2 class="no-margin-bottom">Department : {!! \Illuminate\Support\Facades\Session::get('session_user_dept_name') !!} </h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>

    <style>
        a, a:hover {
            color: white;
        }
        .table-wrapper-scroll-y {
            display: block;
            max-height: 400px;
            overflow-y: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }


        table {
            width: auto;
        }

        thead, tbody, tr, td, th { display: block; }

        tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        thead th {
            height: 60px;

            /*text-align: left;*/
        }

        tbody {
            height: 500px;
            overflow-y: auto;
        }

        thead {
            /* fallback */
        }


        tbody td, thead th {
            width: 90px;
            float: left;
        }


    </style>



    <div class="container-fluid">

        <div class="row">
            {{--<div class="col-md-6">--}}
                {{--<div class="pull-left">--}}

                    {{--<form class="form-inline" method="get" action="{{ route('roster/approveRosterIndex') }}">--}}
                        {{--<div class="form-group mx-sm-3 mb-2">--}}
                            {{--<label for="search_name" class="sr-only">Search by ID/Name</label>--}}
                            {{--<input type="text" class="form-control typeahead" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">--}}
                        {{--</div>--}}

                        {{--{!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}--}}

                        {{--<button type="submit" class="btn btn-secondary mb-2"><i class="fa fa-search">Search</i></button>--}}
                    {{--</form>--}}


                {{--</div>--}}
            {{--</div>--}}

            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">

                    <form class="form-inline" method="get" action="{{ route('roster/approveRosterIndex') }}">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="search_name" class="sr-only">Search by ID/Name</label>
                            <input type="text" class="form-control typeahead" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">
                        </div>

                        {!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}

                        <button type="submit" class="btn btn-secondary btn-sm mb-2"><i class="fa fa-search">Search</i></button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="pull-left">

                    <form class="form-inline" method="get" action="{{ route('roster/approveRosterIndex') }}">
                        <div class="form-group mx-sm-2">
                            {{--<label for="section_id">Section</label>--}}
                            {!! Form::select('section_id',$sections, null ,array('id'=>'section_id','class'=>'form-control','placeholder'=>'section search')) !!}
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search">Search</i></button>
                    </form>
                </div>
            </div>

        </div>



    @if(!empty($data))

        @php($i=0)


        <div class="wrapper" style="margin: 10px; width: 100%; max-width: 1024px">
            <ul class="tabs clearfix" data-tabgroup="first-tab-group">
                <li><a href="#tab1" class="active">Week 1</a></li>
                <li><a href="#tab2">Week 2</a></li>
                <li><a href="#tab3">Week 3</a></li>
                <li><a href="#tab4">Week 4</a></li>
                <li><a href="#tab5">Week 5</a></li>
            </ul>

            <p style="color: RED; font-weight: bold">সংশ্লিস্ট অফিসিয়ালের যে সমস্ত দিনের রোস্টার দেওয়া হয় নাই সেই সমস্ত দিনে তাকে জেনারেল রোস্টার হিসাবে গন্য করা হবে।</p>

            {{--{!! Form::hidden('is_previous',0, array('id' => 'is_previous')) !!}--}}

            @if($previous > 0)
            <p style="color: RED; font-weight: bold">You have Un Approved Previous Months Roster. Please Approve Those</p>
            @endif

            <section id="first-tab-group" class="tabgroup">
                <div id="tab1">
                    <form method="post" action="{{ route('roster/approve') }}" >

                        @if($previous == 0)
                            {!! Form::hidden('is_previous',0, array('id' => 'is_previous')) !!}
                        @endif

                        @if($previous > 0)
                            {!! Form::hidden('is_previous',$previous, array('id' => 'is_previous')) !!}
                        @endif



                        <table class="table table-striped table-hover" id="refresh">
                            <thead>
                                <tr style="background-color: rgba(24,149,255,0.56)">
                                    <th style="min-width: 30px;">{!! Form::checkbox('check-one',null, false,array('id'=>'check-one')) !!}</th>
                                    <th style="min-width: 200px;">Name</th>
                                    <th style="min-width: 70px;">Day 1</th>
                                    <th style="min-width: 70px;">Day 2</th>
                                    <th style="min-width: 70px;">Day 3</th>
                                    <th style="min-width: 70px;">Day 4</th>
                                    <th style="min-width: 70px;">Day 5</th>
                                    <th style="min-width: 70px;">Day 6</th>
                                    <th style="min-width: 70px;">Day 7</th>
                                </tr>
                            </thead>

                                @csrf
                                <tbody>

                                    @foreach($data as $i=>$row)
                                        <tr>
                                            <td style="min-width: 30px;">{!! Form::checkbox('check[]',$row->id, false) !!}</td>
                                            <td style="min-width: 200px;">{!! $row->professional->employee_id !!} <br/>{!! $row->professional->personal->full_name !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_01) !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_02) !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_03) !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_04) !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_05) !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_06) !!}</td>
                                            <td style="min-width: 70px;">{!! get_shift_data($row->day_07) !!}</td>
                                        <tr/>
                                    @endforeach

                                    {!! Form::hidden('total_employee',$i, array('id' => 'total_employee')) !!}
                                </tbody>

                            <tfoot>

                                <tr>
                                    <td><button class="btn btn-secondary btn-approve pull-left" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Approve </button></td>
                                    {{--<td><button class="btn btn-danger btn-reject pull-right" type="submit" name="action" value="reject"> <i class="fa fa-trash"></i>Reject</button></td>--}}
                                </tr>

                            </tfoot>
                        </table>
                    </form>
                </div>
                <div id="tab2">

                    <table class="table table-striped table-hover table-success">
                        <thead>
                            <tr style="background-color: rgba(24,149,255,0.56)">
{{--                                <th style="min-width: 30px;">{!! Form::checkbox('check[]',null, false,array('id'=>'check-two')) !!}</th>--}}
                                <th style="min-width: 200px;">Name</th>
                                <th style="min-width: 70px;">Day 8</th>
                                <th style="min-width: 70px;">Day 9</th>
                                <th style="min-width: 70px;">Day 10</th>
                                <th style="min-width: 70px;">Day 11</th>
                                <th style="min-width: 70px;">Day 12</th>
                                <th style="min-width: 70px;">Day 13</th>
                                <th style="min-width: 70px;">Day 14</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $i=>$row)
                                <tr>
{{--                                    <td style="min-width: 30px;">{!! Form::checkbox('check[]',$row->id, false) !!}</td>--}}
                                    <td style="min-width: 200px;">{!! $row->professional->employee_id !!} <br/>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! get_shift_data($row->day_08) !!}</td>
                                    <td>{!! get_shift_data($row->day_09) !!}</td>
                                    <td>{!! get_shift_data($row->day_10) !!}</td>
                                    <td>{!! get_shift_data($row->day_11) !!}</td>
                                    <td>{!! get_shift_data($row->day_12) !!}</td>
                                    <td>{!! get_shift_data($row->day_13) !!}</td>
                                    <td>{!! get_shift_data($row->day_14) !!}</td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>

                </div>
                <div id="tab3">

                    <table class="table table-striped table-hover table-secondary">
                        <thead>
                            <tr style="background-color: rgba(24,149,255,0.56)">
                                {{--<th style="min-width: 30px;">{!! Form::checkbox('check[]',null, false,array('id'=>'check-three')) !!}</th>--}}
                                <th style="min-width: 200px;">Name</th>
                                <th style="min-width: 70px;">Day 15</th>
                                <th style="min-width: 70px;">Day 16</th>
                                <th style="min-width: 70px;">Day 17</th>
                                <th style="min-width: 70px;">Day 18</th>
                                <th style="min-width: 70px;">Day 19</th>
                                <th style="min-width: 70px;">Day 20</th>
                                <th style="min-width: 70px;">Day 21</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $i=>$row)
                                <tr>
                                    {{--<td style="min-width: 30px;">{!! Form::checkbox('check[]',$row->id, false) !!}</td>--}}
                                    <td style="min-width: 200px;">{!! $row->professional->employee_id !!} <br/>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! get_shift_data($row->day_15) !!}</td>
                                    <td>{!! get_shift_data($row->day_16) !!}</td>
                                    <td>{!! get_shift_data($row->day_17) !!}</td>
                                    <td>{!! get_shift_data($row->day_18) !!}</td>
                                    <td>{!! get_shift_data($row->day_19) !!}</td>
                                    <td>{!! get_shift_data($row->day_20) !!}</td>
                                    <td>{!! get_shift_data($row->day_21) !!}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <div id="tab4">

                    <table class="table table-striped table-hover table-info">
                        <thead>
                            <tr style="background-color: rgba(24,149,255,0.56)">
{{--                                <th style="min-width: 30px;">{!! Form::checkbox('check[]',null, false,array('id'=>'check-four')) !!}</th>--}}
                                <th style="min-width: 200px;">Name</th>
                                <th style="min-width: 70px;">Day 22</th>
                                <th style="min-width: 70px;">Day 23</th>
                                <th style="min-width: 70px;">Day 24</th>
                                <th style="min-width: 70px;">Day 25</th>
                                <th style="min-width: 70px;">Day 26</th>
                                <th style="min-width: 70px;">Day 27</th>
                                <th style="min-width: 70px;">Day 28</th>
                            </tr>
                        </thead>


                        <tbody>
                        @foreach($data as $i=>$row)
                            <tr>
                                {{--<td style="min-width: 30px;">{!! Form::checkbox('check[]',$row->id, false) !!}</td>--}}
                                <td style="min-width: 200px;">{!! $row->professional->employee_id !!} <br/>{!! $row->professional->personal->full_name !!}</td>
                                <td>{!! get_shift_data($row->day_22) !!}</td>
                                <td>{!! get_shift_data($row->day_23) !!}</td>
                                <td>{!! get_shift_data($row->day_24) !!}</td>
                                <td>{!! get_shift_data($row->day_25) !!}</td>
                                <td>{!! get_shift_data($row->day_26) !!}</td>
                                <td>{!! get_shift_data($row->day_27) !!}</td>
                                <td>{!! get_shift_data($row->day_28) !!}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>
                <div id="tab5">


                    <table class="table table-striped table-hover table-danger">
                        <thead>
                        <tr style="background-color: rgba(24,149,255,0.56)">
{{--                            <th style="min-width: 30px;">{!! Form::checkbox('check[]',null, false,array('id'=>'check-five')) !!}</th>--}}
                            <th style="min-width: 200px;">Name</th>
                            <th style="min-width: 70px;">Day 29</th>
                            <th style="min-width: 70px;">Day 30</th>
                            <th style="min-width: 70px;">Day 31</th>
                        </tr>
                        </thead>

                            @foreach($data as $i=>$row)
                                <tr>
                                    {{--<td style="min-width: 30px;">{!! Form::checkbox('check[]',$row->id, false) !!}</td>--}}
                                    <td style="min-width: 200px;">{!! $row->professional->employee_id !!} <br/>{!! $row->professional->personal->full_name !!}</td>
                                    <td>{!! get_shift_data($row->day_29) !!}</td>
                                    <td>{!! get_shift_data($row->day_30) !!}</td>
                                    <td>{!! get_shift_data($row->day_31) !!}</td>
                                </tr>
                            @endforeach

                        <tbody>

                        </tbody>
                    </table>

                </div>
            </section>
        </div>
        @endif






        {{--<div class="table-wrapper-scroll-y">--}}

            {{--<table class="table table-bordered table-striped">--}}
                {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th style="min-width: 30px;">{!! Form::checkbox('check[]',null, false,array('id'=>'check-all')) !!}</th>--}}
                        {{--<th style="min-width: 85px;">ID</th>--}}
                        {{--<th style="min-width: 200px;">Name</th>--}}
                        {{--<th style="min-width: 70px;">Day 1</th>--}}
                        {{--<th style="min-width: 70px;">Day 2</th>--}}
                        {{--<th style="min-width: 70px;">Day 3</th>--}}
                        {{--<th style="min-width: 70px;">Day 4</th>--}}
                        {{--<th style="min-width: 70px;">Day 5</th>--}}
                        {{--<th style="min-width: 70px;">Day 6</th>--}}
                        {{--<th style="min-width: 70px;">Day 7</th>--}}
                        {{--<th style="min-width: 70px;">Day 8</th>--}}
                        {{--<th style="min-width: 70px;">Day 9</th>--}}
                        {{--<th style="min-width: 70px;">Day 10</th>--}}
                        {{--<th style="min-width: 70px;">Day 11</th>--}}
                        {{--<th style="min-width: 70px;">Day 12</th>--}}
                        {{--<th style="min-width: 70px;">Day 13</th>--}}
                        {{--<th style="min-width: 70px;">Day 14</th>--}}
                        {{--<th style="min-width: 70px;">Day 15</th>--}}
                        {{--<th style="min-width: 70px;">Day 16</th>--}}
                        {{--<th style="min-width: 70px;">Day 17</th>--}}
                        {{--<th style="min-width: 70px;">Day 18</th>--}}
                        {{--<th style="min-width: 70px;">Day 19</th>--}}
                        {{--<th style="min-width: 70px;">Day 20</th>--}}
                        {{--<th style="min-width: 70px;">Day 21</th>--}}
                        {{--<th style="min-width: 70px;">Day 22</th>--}}
                        {{--<th style="min-width: 70px;">Day 23</th>--}}
                        {{--<th style="min-width: 70px;">Day 24</th>--}}
                        {{--<th style="min-width: 70px;">Day 25</th>--}}
                        {{--<th style="min-width: 70px;">Day 26</th>--}}
                        {{--<th style="min-width: 70px;">Day 27</th>--}}
                        {{--<th style="min-width: 70px;">Day 28</th>--}}
                        {{--<th style="min-width: 70px;">Day 29</th>--}}
                        {{--<th style="min-width: 70px;">Day 30</th>--}}
                        {{--<th style="min-width: 70px;">Day 31</th>--}}
                    {{--</tr>--}}

                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($data as $i=>$row)--}}
                    {{--<tr>--}}
                        {{--<td>{!! Form::checkbox('check[]',$row->id, false) !!}</td>--}}
                        {{--<td>{!! $row->professional->employee_id !!}</td>--}}
                        {{--<td>{!! $row->professional->personal->full_name !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_01) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_02) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_03) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_04) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_05) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_06) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_07) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_08) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_09) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_10) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_11) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_12) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_13) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_14) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_15) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_16) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_17) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_18) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_19) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_20) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_21) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_22) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_23) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_24) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_25) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_26) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_27) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_28) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_29) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_30) !!}</td>--}}
                        {{--<td>{!! get_shift_data($row->day_31) !!}</td>--}}


                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_02) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_03) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_04) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_05) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_06) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_07) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_08) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_09) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_10) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_11) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_12) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_13) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_14) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_15) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_16) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_17) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_18) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_19) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_20) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_21) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_22) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_23) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_24) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_25) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_26) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_27) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_28) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_29) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_30) !!}</td>--}}
                        {{--<td style="min-width: 70px;">{!! get_shift_data($row->day_31) !!}</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}

                {{--<tfoot>--}}
                    {{--<tr>--}}
                        {{--<td colspan="4"><button class="btn btn-secondary btn-approve" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Approve </button></td>--}}
                        {{--<td colspan="4"><button class="btn btn-danger btn-reject pull-right" type="submit" name="action" value="reject"> <i class="fa fa-trash"></i>Reject</button></td>--}}
                    {{--</tr>--}}
                {{--</tfoot>--}}
            {{--</table>--}}

        {{--</div>--}}



        {{--<div class="row">--}}
            {{--<div class="col-md-6">--}}
                {{--<div class="pull-left">--}}

                    {{--<form class="form-inline" method="get" action="{{ route('roster/employeeRosterIndex') }}">--}}
                        {{--<div class="form-group mx-sm-3 mb-2">--}}
                            {{--<label for="search_name" class="sr-only">Search by ID/Name</label>--}}
                            {{--<input type="text" class="form-control typeahead" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">--}}
                        {{--</div>--}}

                        {{--{!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}--}}

                        {{--<button type="submit" class="btn btn-secondary mb-2"><i class="fa fa-search">Search</i></button>--}}
                    {{--</form>--}}


                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-md-6">--}}
                {{--<div class="pull-right">--}}
                    {{--<a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}

        {{--<div class="table-responsive" style="overflow-y: auto;">--}}
        {{--<table class="table table-bordered bg-light table-striped">--}}
            {{--<thead class="bg-dark" style="color: white">--}}
            {{--<tr>--}}
                {{--<th>Action</th>--}}
                {{--<th>ID</th>--}}
                {{--<th>Name</th>--}}
                {{--<th style="width: 120px">Day 1</th>--}}
                {{--<th>Day 2</th>--}}
                {{--<th>Day 3</th>--}}
                {{--<th>Day 4</th>--}}
                {{--<th>Day 5</th>--}}
                {{--<th>Day 6</th>--}}
                {{--<th>Day 7</th>--}}
                {{--<th>Day 8</th>--}}
                {{--<th>Day 9</th>--}}
                {{--<th>Day 10</th>--}}
                {{--<th>Day 11</th>--}}
                {{--<th>Day 12</th>--}}
                {{--<th>Day 13</th>--}}
                {{--<th>Day 14</th>--}}
                {{--<th>Day 15</th>--}}
                {{--<th>Day 16</th>--}}
                {{--<th>Day 17</th>--}}
                {{--<th>Day 18</th>--}}
                {{--<th>Day 19</th>--}}
                {{--<th>Day 20</th>--}}
                {{--<th>Day 21</th>--}}
                {{--<th>Day 22</th>--}}
                {{--<th>Day 23</th>--}}
                {{--<th>Day 24</th>--}}
                {{--<th>Day 25</th>--}}
                {{--<th>Day 26</th>--}}
                {{--<th>Day 27</th>--}}
                {{--<th>Day 28</th>--}}
                {{--<th>Day 29</th>--}}
                {{--<th>Day 30</th>--}}
                {{--<th>Day 31</th>--}}

            {{--</tr>--}}
            {{--</thead>--}}

            {{--{!! Form::open(['url' => 'roster/approve', 'method' => 'post']) !!}--}}

            {{--<tbody>--}}

            {{--@foreach($data as $i=>$row)--}}
                {{--<tr>--}}
                    {{--<td>{!! Form::checkbox('check[]',$row->id, false) !!}</td>--}}
                    {{--<td>{!! $row->professional->employee_id !!}</td>--}}
                    {{--<td>{!! $row->professional->personal->full_name !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_01) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_02) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_03) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_04) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_05) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_06) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_07) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_08) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_09) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_10) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_11) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_12) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_13) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_14) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_15) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_16) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_17) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_18) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_19) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_20) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_21) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_22) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_23) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_24) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_25) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_26) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_27) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_28) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_29) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_30) !!}</td>--}}
                    {{--<td>{!! get_shift_data($row->day_31) !!}</td>--}}


                {{--</tr>--}}
            {{--@endforeach--}}

            {{--</tbody>--}}
            {{--<tfoot>--}}
            {{--<tr>--}}
                {{--<td colspan="4"><button class="btn btn-secondary btn-approve" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Approve </button></td>--}}
                {{--<td colspan="4"><button class="btn btn-danger btn-reject pull-right" type="submit" name="action" value="reject"> <i class="fa fa-trash"></i>Reject</button></td>--}}
            {{--</tr>--}}
            {{--</tfoot>--}}
            {{--{!! Form::close() !!}--}}

        {{--</table>--}}
        {{--</div>--}}
        {{--<nav>--}}
            {{--<ul class="pagination justify-content-end">--}}
                {{--{{$data->render()}}--}}
            {{--</ul>--}}
        {{--</nav>--}}
    </div>


@endsection

@push('scripts')

    <script>


        var autocomplete_path = "{{ url('autocomplete/departmentEmployee') }}";

        $(document).on('click', '.form-control.typeahead', function() {

            $(this).typeahead({
                minLength: 2,
                displayText:function (data) {
                    return data.full_name + " : " + data.professional.employee_id;
                },

                source: function (query, process) {
                    $.ajax({
                        url: autocomplete_path,
                        type: 'GET',
                        dataType: 'JSON',
                        data: 'query=' + query ,
                        success: function(data) {
                            return process(data);
                        }
                    });
                },
                afterSelect: function (data) {

                    document.getElementById ("search_id").value= data.professional.employee_id;
                }
            });
        });



        $("#check-one").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });


        $('.tabgroup > div').hide();
        $('.tabgroup > div:first-of-type').show();
        $('.tabs a').click(function(e){
            e.preventDefault();
            var $this = $(this),
                tabgroup = '#'+$this.parents('.tabs').data('tabgroup'),
                others = $this.closest('li').siblings().children('a'),
                target = $this.attr('href');
            others.removeClass('active');
            $this.addClass('active');
            $(tabgroup).children('div').hide();
            $(target).show();

        });


    </script>

@endpush