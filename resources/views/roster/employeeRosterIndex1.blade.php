@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Roster Entry For <span style="color: #980000; font-weight: bold">Year : {!! $r_year !!} Month: {!! get_month_from_number($r_month) !!}</span> </h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="pull-left">

                    <form class="form-inline" id="search-form" method="get" action="{{ route('roster/employeeRosterIndex') }}">


                        {!! Form::hidden('r_year', $r_year, array('id' => 'r_year')) !!}
                        {!! Form::hidden('r_month', $r_month, array('id' => 'r_month')) !!}


                        <div class="form-group mx-sm-3 mb-1">
                            {!! Form::selectYear('search_year', 2019, 2025,2019,array('id'=>'search_year','class'=>'form-control')) !!}
                        </div>

                        {!! Form::hidden('search_new', 1, array('id' => 'search_new')) !!}

                        <div class="form-group mx-sm-3 mb-1">
                            {!! Form::selectMonth('search_month',$r_month,['id' => 'search_month','class'=>'form-control']) !!}
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-search">Search</i></button>
                    </form>
                </div>
            </div>
        </div>

        {!! Form::hidden('r_year', $r_year, array('id' => 'r_year')) !!}
        {!! Form::hidden('r_month', $r_month, array('id' => 'r_month')) !!}


        <!-- <div class="wrapper" style="margin: 10px; width: 100%; max-width: 3024px"> -->
        <div>
            <ul class="tabs clearfix" data-tabgroup="first-tab-group">
                <li><a href="#tab1" class="active">Week 1</a></li>
            </ul>


            <span style="color: #980000; font-weight: bold">Year : {!! $r_year !!} Month: {!! get_month_from_number($r_month) !!}</span>

            <table class="table">

                <tbody>

                    <td width="50%">
                        <form class="form-inline" method="get" action="{{ route('roster/employeeRosterIndex') }}">

                            {!! Form::hidden('r_year', $r_year, array('id' => 'r_year')) !!}
                            {!! Form::hidden('r_month', $r_month, array('id' => 'r_month')) !!}

                            <div class="form-group mx-sm-6 mb-1">
                                <label for="search_name" class="sr-only">Search by ID/Name</label>
                                <input type="text" class="form-control typeahead" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">
                            </div>

                            {!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}

                            <button type="submit" class="btn btn-primary btn-sm mb-1"><i class="fa fa-search">Search</i></button>
                        </form>
                    </td>

                    <td width="50%">
                        <form class="form-inline" method="get" action="{{ route('roster/employeeRosterIndex') }}">

                            {!! Form::hidden('r_year', $r_year, array('id' => 'r_year')) !!}
                            {!! Form::hidden('r_month', $r_month, array('id' => 'r_month')) !!}

                            <div class="form-group mx-sm-2">
                                {{--<label for="section_id">Section</label>--}}
                                {!! Form::select('section_id',$sections, null ,array('id'=>'section_id','class'=>'form-control','placeholder'=>'section search')) !!}
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search">Search</i></button>
                        </form>
                    </td>

                </tbody>

            </table>


                <div style="overflow: scroll;" id="tab1">

                    <table class="table table-striped table-hover table-bordered" id="refresh">
                        <thead>
                            <tr>
                                <th width="150px" style="font-weight: bold">Name</th>
                                <th>01<br/>{!! get_roster_day_from_number(01,$r_year,$r_month) !!}</th>
                                <th>02<br/>{!! get_roster_day_from_number(02,$r_year,$r_month) !!}</th>
                                <th>03<br/>{!! get_roster_day_from_number(03,$r_year,$r_month) !!}</th>
                                <th>04<br/>{!! get_roster_day_from_number(04,$r_year,$r_month) !!}</th>
                                <th>05<br/>{!! get_roster_day_from_number(05,$r_year,$r_month) !!}</th>
                                <th>06<br/>{!! get_roster_day_from_number(06,$r_year,$r_month) !!}</th>
                                <th>07<br/>{!! get_roster_day_from_number(07,$r_year,$r_month) !!}</th>
                                <th width="100px">Loc</th>
                                <th>08<br/>{!! get_roster_day_from_number(8,$r_year,$r_month) !!}</th>
                                <th>09<br/>{!! get_roster_day_from_number(9,$r_year,$r_month) !!}</th>
                                <th>10<br/>{!! get_roster_day_from_number(10,$r_year,$r_month) !!}</th>
                                <th>11<br/>{!! get_roster_day_from_number(11,$r_year,$r_month) !!}</th>
                                <th>12<br/>{!! get_roster_day_from_number(12,$r_year,$r_month) !!}</th>
                                <th>13<br/>{!! get_roster_day_from_number(13,$r_year,$r_month) !!}</th>
                                <th>14<br/>{!! get_roster_day_from_number(14,$r_year,$r_month) !!}</th>
                                <th width="100px">Loc</th>
                                <th>15<br/>{!! get_roster_day_from_number(15,$r_year,$r_month) !!}</th>
                                <th>16<br/>{!! get_roster_day_from_number(16,$r_year,$r_month) !!}</th>
                                <th>17<br/>{!! get_roster_day_from_number(17,$r_year,$r_month) !!}</th>
                                <th>18<br/>{!! get_roster_day_from_number(18,$r_year,$r_month) !!}</th>
                                <th>19<br/>{!! get_roster_day_from_number(19,$r_year,$r_month) !!}</th>
                                <th>20<br/>{!! get_roster_day_from_number(20,$r_year,$r_month) !!}</th>
                                <th>21<br/>{!! get_roster_day_from_number(21,$r_year,$r_month) !!}</th>
                                <th width="100px">Loc</th>
                                <th>22<br/>{!! get_roster_day_from_number(22,$r_year,$r_month) !!}</th>
                                <th>23<br/>{!! get_roster_day_from_number(23,$r_year,$r_month) !!}</th>
                                <th>24<br/>{!! get_roster_day_from_number(24,$r_year,$r_month) !!}</th>
                                <th>25<br/>{!! get_roster_day_from_number(25,$r_year,$r_month) !!}</th>
                                <th>26<br/>{!! get_roster_day_from_number(26,$r_year,$r_month) !!}</th>
                                <th>27<br/>{!! get_roster_day_from_number(27,$r_year,$r_month) !!}</th>
                                <th>28<br/>{!! get_roster_day_from_number(28,$r_year,$r_month) !!}</th>
                                <th width="100px">Loc</th>
                                @if($month_days > 28)
                                <th>29<br/>{!! get_roster_day_from_number(29,$r_year,$r_month) !!}</th>
                                @endif
                                @if($month_days > 29)
                                <th>30<br/>{!! get_roster_day_from_number(30,$r_year,$r_month) !!}</th>
                                @endif
                                @if($month_days > 30)
                                <th>31<br/>{!! get_roster_day_from_number(31,$r_year,$r_month) !!}</th>
                                @endif
                                <th width="100px">Loc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($emp_list as $i=>$row)
                            
                                <tr>

                                    <td>{!! $row->personal->full_name !!}<br/>{!! $row->employee_id !!}</td>

                                    <td>{!! Form::select('day_01',$shifts, isset($row->roster->day_01)? $row->roster->day_01 : null ,array('id'=>'day-1-'.$i,'placeholder'=>'Select shift')) !!}</td>

                                    <td>{!! Form::select('day_02',$shifts,isset($row->roster->day_02)? $row->roster->day_02 : null,array('id'=>'day-2-'.$i,'placeholder'=>'Select Shift')) !!}</td>
                                    
                                    <td>{!! Form::select('day_03',$shifts,isset($row->roster->day_03)? $row->roster->day_03 : null,array('id'=>'day-3-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    
                                    <td>{!! Form::select('day_04',$shifts,isset($row->roster->day_04)? $row->roster->day_04 : null,array('id'=>'day-4-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    
                                    <td>{!! Form::select('day_05',$shifts,$row->roster->day_05,array('id'=>'day-5-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    
                                    <td>{!! Form::select('day_06',$shifts,$row->roster->day_06,array('id'=>'day-6-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    
                                    <td>{!! Form::select('day_07',$shifts,$row->roster->day_07,array('id'=>'day-7-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    
                                    <td>{!! Form::select('loc_01',$locations,$row->roster->loc_01,array('id'=>'loc-1-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                        {!! Form::hidden('week_first', 'first', array('id' => 'week_first')) !!}
                                    <td>{!! Form::select('day_08',$shifts,$row->roster->day_08,array('id'=>'day-8-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_09',$shifts,$row->roster->day_09,array('id'=>'day-9-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_10',$shifts,$row->roster->day_10,array('id'=>'day-10-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_11',$shifts,$row->roster->day_11,array('id'=>'day-11-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_12',$shifts,$row->roster->day_12,array('id'=>'day-12-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_13',$shifts,$row->roster->day_13,array('id'=>'day-13-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_14',$shifts,$row->roster->day_14,array('id'=>'day-14-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('loc_02',$locations,$row->roster->loc_02,array('id'=>'loc-2-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_15',$shifts,$row->roster->day_15,array('id'=>'day-15-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_16',$shifts,$row->roster->day_16,array('id'=>'day-16-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_17',$shifts,$row->roster->day_17,array('id'=>'day-17-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_18',$shifts,$row->roster->day_18,array('id'=>'day-18-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_19',$shifts,$row->roster->day_19,array('id'=>'day-19-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_20',$shifts,$row->roster->day_20,array('id'=>'day-20-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_21',$shifts,$row->roster->day_21,array('id'=>'day-21-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('loc_03',$locations,$row->roster->loc_03,array('id'=>'loc-3-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_22',$shifts,$row->roster->day_22,array('id'=>'day-22-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_23',$shifts,$row->roster->day_23,array('id'=>'day-23-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_24',$shifts,$row->roster->day_24,array('id'=>'day-24-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_25',$shifts,$row->roster->day_25,array('id'=>'day-25-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_26',$shifts,$row->roster->day_26,array('id'=>'day-26-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_27',$shifts,$row->roster->day_27,array('id'=>'day-27-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_28',$shifts,$row->roster->day_28,array('id'=>'day-28-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    <td>{!! Form::select('day_04',$locations,$row->roster->loc_04,array('id'=>'loc-4-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    @if($month_days > 28)
                                        <td>{!! Form::select('day_29',$shifts,$row->roster->day_29,array('id'=>'day-29-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    @endif
                                    @if($month_days > 29)
                                        <td>{!! Form::select('day_30',$shifts,$row->roster->day_30,array('id'=>'day-30-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    @endif
                                    @if($month_days > 30)
                                        <td>{!! Form::select('day_31',$shifts,$row->roster->day_31,array('id'=>'day-31-'.$i,'placeholder'=>'Select shift')) !!}</td>
                                    @endif
                                    <td>{!! Form::select('loc_05',$locations,$row->roster->loc_05,array('id'=>'loc-5-'.$i,'placeholder'=>'Select shift')) !!}</td>

                                    <td><button type="submit" name="button_one" id="week-one-{!! $i !!}" value="{!! $row->employee_id !!}" class="btn btn-week-one btn-primary btn-sm">Submit</button></td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                 
        </div>


    </div> <!--/.Container-->


@endsection

@push('scripts')

    <script>

        // Filter Employee Table
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

        // End


        $(document).ready(function(){

            $(document).on('click', '.btn-week-one', function() {
                // e.preventDefault();

                input_id = $(this).attr('id').split('-');
                item_id = parseInt(input_id[input_id.length-1]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = 'weekdays/save';

                // confirm then
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',

                    data: {method: '_POST', submit: true, employee_id:$('#week-one-' + item_id).val(),
                        day_01:$('#day-1-' + item_id).val(),
                        day_02:$('#day-2-' + item_id).val(),
                        day_03:$('#day-3-' + item_id).val(),
                        day_04:$('#day-4-' + item_id).val(),
                        day_05:$('#day-5-' + item_id).val(),
                        day_06:$('#day-6-' + item_id).val(),
                        day_07:$('#day-7-' + item_id).val(),
                        loc_01:$('#loc-1-' + item_id).val(),
                        day_08:$('#day-8-' + item_id).val(),
                        day_09:$('#day-9-' + item_id).val(),
                        day_10:$('#day-10-' + item_id).val(),
                        day_11:$('#day-11-' + item_id).val(),
                        day_12:$('#day-12-' + item_id).val(),
                        day_13:$('#day-13-' + item_id).val(),
                        day_14:$('#day-14-' + item_id).val(),
                        loc_02:$('#loc-2-' + item_id).val(),
                        day_15:$('#day-15-' + item_id).val(),
                        day_16:$('#day-16-' + item_id).val(),
                        day_17:$('#day-17-' + item_id).val(),
                        day_18:$('#day-18-' + item_id).val(),
                        day_19:$('#day-19-' + item_id).val(),
                        day_20:$('#day-20-' + item_id).val(),
                        day_21:$('#day-21-' + item_id).val(),
                        loc_03:$('#loc-3-' + item_id).val(),
                        day_22:$('#day-22-' + item_id).val(),
                        day_23:$('#day-23-' + item_id).val(),
                        day_24:$('#day-24-' + item_id).val(),
                        day_25:$('#day-25-' + item_id).val(),
                        day_26:$('#day-26-' + item_id).val(),
                        day_27:$('#day-27-' + item_id).val(),
                        day_28:$('#day-28-' + item_id).val(),
                        loc_04:$('#loc-4-' + item_id).val(),
                        day_29:$('#day-29-' + item_id).val(),
                        day_30:$('#day-30-' + item_id).val(),
                        day_31:$('#day-31-' + item_id).val(),
                        loc_05:$('#loc-5-' + item_id).val(),

                        week_id:$('#week_first').val(),
                        r_month:$('#r_month').val(),
                        r_year:$('#r_year').val(),
                    },

                    error: function (request, status, error) {
                        alert(request.responseText);
                    },

                    success: function (data) {

                         //alert(data);
                        alert('Roster updated');
                    },

                });


                // window.location.href = $(this).val();

            });

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


        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        idleTimer();

    </script>

@endpush