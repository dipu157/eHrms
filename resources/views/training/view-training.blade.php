@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Division Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>

        <div class=" col-md-6 col-lg-6 ">
            <table class="table table-primary">
                <tbody>


                    <tr>
                        <td>Title:</td>
                        <td>{!! $training->title !!}</td>
                    </tr>

                    <tr>
                        <td>Mobile:</td>
                        <td>{!! $training->description !!}</td>
                    </tr>

                    <tr>
                        <td>Total Participants:</td>
                        <td>{!! $training->participants !!}</td>
                    </tr>

                    <tr>
                        <td>Total Attend:</td>
                        <td>{!! $training->attended !!}</td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>{!! $training->status === 1 ? 'Open' : 'Closed' !!}</td>
                    </tr>
                </tbody>
            </table>

        </div>






        {{--<div class="row justify-content-left">--}}
            {{--<div class="col-md-10">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-header">List of Attended Trainees</div>--}}

                    {{--<div class="card-body">--}}

                        {{--<table class="table table-responsive table-hover table-bordered">--}}
                            {{--<thead>--}}
                            {{--<tr style="background-color: rgba(25,192,217,0.1)">--}}
                                {{--<th colspan="2" width="80px">Action</th>--}}
                                {{--<th width="400px">Department</th>--}}
                                {{--<th>Participant</th>--}}
                                {{--<th>Attended</th>--}}
                                {{--<th>Absent</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}

                            {{--@foreach($training-> as $i=>$department)--}}


                                {{--<tbody>--}}

                                {{--<tr style="background-color: rgba(126,0,0,0.23)" class="clickable" data-toggle="collapse" data-target="#group-of-rows-{!! $i+1 !!}" aria-expanded="false" aria-controls="group-of-rows-1">--}}
                                    {{--<td colspan="2" width="80px"><i class="fa fa-plus" aria-hidden="true"></i></td>--}}
                                    {{--<td width="400px">{!! $department->department->name !!}</td>--}}
                                    {{--<td>{!! $department->participant !!}</td>--}}
                                    {{--<td>{!! $department->attended !!}</td>--}}
                                    {{--<td>{!! $department->absent !!}</td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}

                                {{--<tbody id="group-of-rows-{!! $i+1 !!}" class="collapse">--}}

                                {{--<tr style="background-color: rgba(159,79,238,0.15)">--}}
                                    {{--<th>SL</th>--}}
                                    {{--<th>ID</th>--}}
                                    {{--<th width="300px">Name</th>--}}
                                    {{--<th>Designation</th>--}}
                                    {{--<th>Status</th>--}}
                                    {{--<th>Evaluation</th>--}}
                                {{--</tr>--}}
                                {{--@php($x=0)--}}
                                {{--@foreach($trainees as $person)--}}

                                    {{--@if($person->department_id == $department->department_id)--}}
                                        {{--@php($x ++)--}}
                                        {{--<tr>--}}
                                            {{--<td>{!! $x !!}</td>--}}
                                            {{--<td>{!! $person->employee_id !!}</td>--}}
                                            {{--<td width="300px">{!! $person->personal->full_name !!}</td>--}}
                                            {{--<td>{!! $person->designation->name !!}</td>--}}
                                            {{--<td>{!! $person->trainee->attended == true ? 'Attended' : null !!}</td>--}}
                                            {{--<td>{!! $person->trainee->evaluation !!}</td>--}}
                                        {{--</tr>--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--@endforeach--}}
                        {{--</table>--}}
                    {{--</div>--}}


                    {{--<div class="card-footer">--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-6 offset-md-1">--}}
                                {{--<button type="submit" class="btn btn-primary btn-print-before" id="action" name="action" value="before">Print Before</button>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-5 text-md-right">--}}
                                {{--<button type="submit" class="btn btn-secondary btn-print-after" id="action" name="action" value="after">Print After</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}



@endsection

