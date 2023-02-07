@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Division Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i>Back</a>
                </div>
            </div>
        </div>


        <div class="row justify-content-left">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Training Schedule Information</div>

                    <div class="card-body">

                        <table class="table table-responsive table-striped table-bordered" width="100%">
                            <tbody>


                            <tr>
                                <td style="font-weight: bold">Title:</td>
                                <td>{!! $training->training->title !!}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold">Details:</td>
                                <td>{!! $training->training->description !!}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold">Schedule:</td>
                                <td>{!! \Carbon\Carbon::parse($training->start_from)->format('d-M-Y H:i') !!} To
                                    {!! \Carbon\Carbon::parse($training->end_on)->format('d-M-Y H:i') !!}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Trainer:</td>
                                <td>{!! $training->trainer !!}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold">Total Participants:</td>
                                <td>{!! $training->participants !!}</td>
                            </tr>

                            {{--@if($training->status === 0)--}}

                            <tr>
                                <td style="font-weight: bold">Total Attend:</td>
                                <td>{!! $training->attended !!}</td>
                            </tr>

                            {{--<tr>--}}
                            {{--<td>Closing Notes</td>--}}
                            {{--<td>{!! $training->closing_notes !!}</td>--}}
                            {{--</tr>--}}

                            {{--@endif--}}

                            <tr>
                                <td style="font-weight: bold">Status</td>
                                <td>{!! $training->status === 1 ? 'Open' : 'Closed' !!}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    {{--<div class="card-footer">--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-6 offset-md-1">--}}
                                {{--<button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-5 text-md-right">--}}
                                {{--<button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                </div>
            </div>
        </div>


        @if (!empty($trainees))

            {!! Form::hidden('training_id', $training->id, array('id' => 'training_id')) !!}

            <div class="row justify-content-left">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">List of Trainees</div>

                        <div class="card-body">

                            <table class="table table-responsive table-hover table-bordered">
                                <thead>
                                    <tr style="background-color: rgba(25,192,217,0.1)">
                                        <th colspan="2" width="80px">Action</th>
                                        <th width="400px">Department</th>
                                        <th>Participant</th>
                                        <th>Attended</th>
                                        <th>Absent</th>
                                    </tr>
                                </thead>

                                @foreach($participants as $i=>$department)


                                <tbody>

                                    <tr style="background-color: rgba(126,0,0,0.23)" class="clickable" data-toggle="collapse" data-target="#group-of-rows-{!! $i+1 !!}" aria-expanded="false" aria-controls="group-of-rows-1">
                                        <td colspan="2" width="80px"><i class="fa fa-plus" aria-hidden="true"></i></td>
                                        <td width="400px">{!! $department->department->name !!}</td>
                                        <td>{!! $department->participant !!}</td>
                                        <td>{!! $department->attended !!}</td>
                                        <td>{!! $department->absent !!}</td>
                                    </tr>
                                </tbody>

                                <tbody id="group-of-rows-{!! $i+1 !!}" class="collapse">

                                    <tr style="background-color: rgba(159,79,238,0.15)">
                                        <th>SL</th>
                                        <th>ID</th>
                                        <th width="300px">Name</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Evaluation</th>
                                    </tr>
                                    @php($x=0)
                                    @foreach($trainees as $person)

                                        @if($person->department_id == $department->department_id)
                                            @php($x ++)
                                            <tr>
                                                <td>{!! $x !!}</td>
                                                <td>{!! $person->employee_id !!}</td>
                                                <td width="300px">{!! $person->personal->full_name !!}</td>
                                                <td>{!! $person->designation->name !!}</td>
                                                <td>{!! $person->trainee->attended == true ? 'Attended' : null !!}</td>
                                                <td>{!! $person->trainee->evaluation !!}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                @endforeach
                            </table>
                        </div>


                        <div class="card-footer">

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary btn-print-before" id="action" name="action" value="before">Print </button>
                                </div>
                             
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
@endsection

@push('scripts')

    <script>

        // document.on("click", ".btn-print", function (e) {
        //     e.preventDefault();
        //
        //     alert('clicked');
        //
        //     // window.location.href = 'training/details/print';
        //
        // });

        $(function (){
            $(document).on("click", ".btn-print-before", function (e) {

                window.location.href = 'print/' + $('#training_id').val() + '/' + 'B';

            });
        });

        $(function (){
            $(document).on("click", ".btn-print-after", function (e) {

                window.location.href = 'print/' + $('#training_id').val() + '/' + 'A';

            });
        });


    </script>

@endpush

