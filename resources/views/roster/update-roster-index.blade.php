@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Roster Update For </span> </h2>
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
        </div>


        <form class="form-inline" id="search-form" method="get" action="{{ route('roster/updateRosterIndex') }}">

            <div class="form-group mx-sm-3 mb-1">
                <label for="search_name" class="sr-only">Search by ID/Name</label>
                <input type="text" class="form-control typeahead" name="search_name" id="search" placeholder="search by name or id" autocomplete="off">
            </div>

            {!! Form::hidden('search_id', null, array('id' => 'search_id')) !!}

            <div class="form-group mx-sm-3 mb-1">
                {!! Form::selectYear('search_year', 2020, 2025,2020,array('id'=>'search_year','class'=>'form-control')) !!}
            </div>

            <div class="form-group mx-sm-3 mb-1">
                {!! Form::selectMonth('search_month',$monthId,['id' => 'search_month','class'=>'form-control']) !!}
            </div>

            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search">Search</i></button>
        </form>

        @if(!empty($emp_data->roster->employee_id))


        <div class="wrapper" style="margin: 10px; width: 100%; max-width: 1024px">
            <ul class="tabs clearfix" data-tabgroup="first-tab-group">
                <li><a href="#tab1" class="active">Week 1</a></li>
                <li><a href="#tab2">Week 2</a></li>
                <li><a href="#tab3">Week 3</a></li>
                <li><a href="#tab4">Week 4</a></li>
                <li><a href="#tab5">Week 5</a></li>
            </ul>

            <div><strong style="font-weight: bold; color: red">Update Roster For The Month {!! get_month_from_number($emp_data->roster->month_id)  !!} {!! $emp_data->roster->r_year !!}</strong> </div>

            <div class="form-group row">
                <label for="location" class="col-sm-1 col-form-label text-md-left">Reason</label>
                <div class="col-sm-8">
                    <div class="input-group mb-3">
                        <input type="text" name="reason" id="reason" class="form-control" required autocomplete="off" autofocus>
                    </div>
                </div>
            </div>


            <section id="first-tab-group" class="tabgroup">
                <div id="tab1">

                    <table class="table table-striped table-hover" id="refresh">
                        <thead>
                        <tr>
                            <th width="150px">Name</th>
                            <th>01</th>
                            <th>02</th>
                            <th>03</th>
                            <th>04</th>
                            <th>05</th>
                            <th>06</th>
                            <th>07</th>
                            <th width="100px">Loc</th>
                            <th></th>
                        </tr>
                        </thead>


                        <tbody>
                        <form class="form-horizontal" id="week1-form" role="form" method="POST" action="">
                            <tr>

                                <td>{!! $emp_data->personal->full_name !!}<br/>{!! $emp_data->employee_id !!}</td>
                                <td>{!! Form::select('day_01',$shifts,$emp_data->roster->day_01,array('id'=>'day-1','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_02',$shifts,$emp_data->roster->day_02,array('id'=>'day-2','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_03',$shifts,$emp_data->roster->day_03,array('id'=>'day-3','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_04',$shifts,$emp_data->roster->day_04,array('id'=>'day-4','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_05',$shifts,$emp_data->roster->day_05,array('id'=>'day-5','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_06',$shifts,$emp_data->roster->day_06,array('id'=>'day-6','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_07',$shifts,$emp_data->roster->day_07,array('id'=>'day-7','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('loc_01',$locations,$emp_data->roster->loc_01,array('id'=>'loc-1','class'=>'form-control')) !!}</td>
                                {!! Form::hidden('roster_id', $emp_data->roster->id, array('id' => 'roster_id')) !!}

                                <td><button type="submit" name="button_one" id="week-one" class="btn btn-week-one btn-primary btn-sm">Submit</button></td>
                            </tr>
                            </form>
                        </tbody>

                    </table>


                </div>
                <div id="tab2">

                    <table class="table table-striped table-hover table-success">
                        <thead>
                        <tr>
                            <th width="150px">Name</th>
                            <th>08</th>
                            <th>09</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th width="100px">Loc</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <form class="form-horizontal" id="week2-form" role="form" method="POST" action="">
                            <tr>

                                <td>{!! $emp_data->personal->full_name !!}<br/>{!! $emp_data->employee_id !!}</td>
                                <td>{!! Form::select('day_08',$shifts,$emp_data->roster->day_08,array('id'=>'day-8','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_09',$shifts,$emp_data->roster->day_09,array('id'=>'day-9','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_10',$shifts,$emp_data->roster->day_10,array('id'=>'day-10','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_11',$shifts,$emp_data->roster->day_11,array('id'=>'day-11','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_12',$shifts,$emp_data->roster->day_12,array('id'=>'day-12','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_13',$shifts,$emp_data->roster->day_13,array('id'=>'day-13','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_14',$shifts,$emp_data->roster->day_14,array('id'=>'day-14','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('loc_02',$locations,$emp_data->roster->loc_02,array('id'=>'loc-2','class'=>'form-control')) !!}</td>
                                {!! Form::hidden('roster_id', $emp_data->roster->id, array('id' => 'roster_id')) !!}
                                <td><button type="submit" name="button_two" id="week-two" class="btn btn-week-two btn-primary btn-sm">Submit</button></td>

                            </tr>
                        </form>
                        </tbody>

                    </table>

                </div>
                <div id="tab3">

                    <table class="table table-striped table-hover table-secondary">
                        <thead>
                        <tr>
                            <th width="150px">Name</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                            <th>19</th>
                            <th>20</th>
                            <th>21</th>
                            <th width="100px">Loc</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <form class="form-horizontal" id="week3-form" role="form" method="POST" action="">
                            <tr>

                                <td>{!! $emp_data->personal->full_name !!}<br/>{!! $emp_data->employee_id !!}</td>
                                <td>{!! Form::select('day_15',$shifts,$emp_data->roster->day_15,array('id'=>'day-15','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_16',$shifts,$emp_data->roster->day_16,array('id'=>'day-16','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_17',$shifts,$emp_data->roster->day_17,array('id'=>'day-17','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_18',$shifts,$emp_data->roster->day_18,array('id'=>'day-18','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_19',$shifts,$emp_data->roster->day_19,array('id'=>'day-19','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_20',$shifts,$emp_data->roster->day_20,array('id'=>'day-20','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_21',$shifts,$emp_data->roster->day_21,array('id'=>'day-21','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('loc_03',$locations,$emp_data->roster->loc_03,array('id'=>'loc-3','class'=>'form-control')) !!}</td>
                                {!! Form::hidden('roster_id', $emp_data->roster->id, array('id' => 'roster_id')) !!}

                                <td><button type="submit" name="button_three" id="week-three" value="{!! $emp_data->employee_id !!}" class="btn btn-week-three btn-primary btn-sm">Submit</button></td>
                            </tr>
                        </form>
                        </tbody>
                    </table>

                </div>
                <div id="tab4">

                    <table class="table table-striped table-hover table-info">
                        <thead>
                        <tr>
                            <th width="150px">Name</th>
                            <th>22</th>
                            <th>23</th>
                            <th>24</th>
                            <th>25</th>
                            <th>26</th>
                            <th>27</th>
                            <th>28</th>
                            <th width="100px">Loc</th>
                            <th></th>
                        </tr>
                        </thead>


                        <tbody>
                        <form class="form-horizontal" id="week4-form" role="form" method="POST" action="">
                            <tr>
                                <td>{!! $emp_data->personal->full_name !!}<br/>{!! $emp_data->employee_id !!}</td>
                                <td>{!! Form::select('day_22',$shifts,$emp_data->roster->day_22,array('id'=>'day-22','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_23',$shifts,$emp_data->roster->day_23,array('id'=>'day-23','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_24',$shifts,$emp_data->roster->day_24,array('id'=>'day-24','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_25',$shifts,$emp_data->roster->day_25,array('id'=>'day-25','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_26',$shifts,$emp_data->roster->day_26,array('id'=>'day-26','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_27',$shifts,$emp_data->roster->day_27,array('id'=>'day-27','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_28',$shifts,$emp_data->roster->day_28,array('id'=>'day-28','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('loc-04',$locations,$emp_data->roster->loc_04,array('id'=>'loc-4','class'=>'form-control')) !!}</td>
                                {!! Form::hidden('roster_id', $emp_data->roster->id, array('id' => 'roster_id')) !!}
                                <td><button type="submit" name="button_four" id="week-four" value="{!! $emp_data->employee_id !!}" class="btn btn-week-four btn-primary btn-sm">Submit</button></td>
                            </tr>
                        </form>
                        </tbody>
                    </table>
                </div>

                <div id="tab5">
                    <table class="table table-striped table-hover table-danger">
                        <thead>
                        <tr>
                            <th width="150px">Name</th>
                            <th>29</th>
                            <th>30</th>
                            <th>31</th>
                            <th width="100px">Loc</th>
                            <th></th>
                        </tr>
                        </thead>


                        <tbody>
                        <form class="form-horizontal" id="week5-form" role="form" method="POST" action="">
                            <tr>
                                <td>{!! $emp_data->personal->full_name !!}<br/>{!! $emp_data->employee_id !!}</td>
                                <td>{!! Form::select('day_29',$shifts,$emp_data->roster->day_29,array('id'=>'day-29','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_30',$shifts,$emp_data->roster->day_30,array('id'=>'day-30','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('day_31',$shifts,$emp_data->roster->day_31,array('id'=>'day-31','class'=>'form-control')) !!}</td>
                                <td>{!! Form::select('loc_05',$locations,$emp_data->roster->loc_05,array('id'=>'loc-5','class'=>'form-control')) !!}</td>
                                {!! Form::hidden('roster_id', $emp_data->roster->id, array('id' => 'roster_id')) !!}
                                <td><button type="submit" name="button_five" id="week-five" value="{!! $emp_data->employee_id !!}" class="btn btn-week-five btn-primary btn-sm">Submit</button></td>
                            </tr>
                        </form>
                        </tbody>
                    </table>

                </div>
            </section>
        </div>

        @endif

        @if(empty($emp_data->roster->employee_id))

                <img class="img-fluid" src="{!! asset('assets/images/nodata.jpg') !!}" alt="No Data Found">

        @endif


    </div> <!--/.Container-->


@endsection

@push('scripts')

    <script>

        // Filter Employee Table


        var autocomplete_path = "{{ url('autocomplete/rosterEmployee') }}";

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

        $(document).delegate('form', 'submit', function(event) {
            var $form = $(this);
            var form_id = $form.attr('id');

            if(form_id =='search-form')
            {
                return true;
            }else{

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = 'updateRoster';

                // confirm then
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: $form.serialize() + "&reason=" + $('#reason').val(),

                    error: function (request, status, error) {
                        alert(request.responseText);
                    },

                    success: function (data) {

                        alert(data.success);
                    },

                });

            }

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



    </script>






@endpush