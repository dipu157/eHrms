@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>



       <div class="container-fluid">

        <div  class="panel panel-default thumbnail">
            <div class="panel-heading no-print">
                <div class="btn-group">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                    <button type="button" onclick="printDiv()" class="btn btn-danger" ><i class="fa fa-print"></i></button>
                </div>
            </div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"><img src="{!! isset($emp_info->photo) ? asset($emp_info->photo) : ($emp_info->gender == 'M' ? asset('assets/images/male.jpeg') : asset('assets/images/female.png'))  !!}" width="200px" height="200px" class="img-rounded img-responsive" alt="..">
                    <br/>
                        <h3 style="font-weight: bold">{!!$emp_info->full_name !!}<br/>
                            {!!isset($emp_info->professional->designation->name) ? $emp_info->professional->designation->name : '' !!}<br/>
                            {!!isset($emp_info->professional->department_id) ? $emp_info->professional->department->name : '' !!}
                        </h3>
                        <br/>
                        <img src="{!! isset($emp_info->signature) ? asset($emp_info->signature) : asset('assets/images/signature.png')  !!}" width="200px" height="50" class="img-rounded img-responsive" alt="Signature">

                    </div>

                    <div class=" col-md-9 col-lg-9 ">

                        <div class="bd-example bd-example-tabs">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-expanded="true">Basic</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-expanded="true">Personal</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-Official-tab" data-toggle="pill" href="#pills-official" role="tab" aria-controls="pills-official" aria-expanded="true">Official</a>
                                </li>

                                {{--<li class="nav-item">--}}
                                    {{--<a class="nav-link" id="pills-dependant-tab" data-toggle="pill" href="#pills-dependant" role="tab" aria-controls="pills-dependant" aria-expanded="true">Dependant</a>--}}
                                {{--</li>--}}
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-posting-tab" data-toggle="pill" href="#pills-posting" role="tab" aria-controls="pills-posting" aria-expanded="true">Posting</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-education-tab" data-toggle="pill" href="#pills-education" role="tab" aria-controls="pills-education" aria-expanded="true">Education</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-promotion-tab" data-toggle="pill" href="#pills-promotion" role="tab" aria-controls="pills-promotion" aria-expanded="true">Promotion</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="pills-leave-tab" data-toggle="pill" href="#pills-leave" role="tab" aria-controls="pills-leave" aria-expanded="true">Leave</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-training-tab" data-toggle="pill" href="#pills-training" role="tab" aria-controls="pills-training" aria-expanded="true">Training</a>
                                </li>

                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <table class="table table-user-information">
                                        <tbody>
                                        {{--<tr>--}}
                                            {{--<td>Title:</td>--}}
                                            {{--<td>{!! $emp_info->title->name !!}</td>--}}
                                        {{--</tr>--}}
                                        <tr>
                                            <td>Name:</td>
                                            <td>{!! $emp_info->full_name !!}</td>
                                        </tr>

                                        <tr>
                                            <td>Email:</td>
                                            <td>{!! $emp_info->email !!}</td>
                                        </tr>

                                        <tr>
                                            <td>Date of Birth:</td>
                                            <td>{!! \Carbon\Carbon::parse($emp_info->dob)->format('d-M-Y') !!}</td>
                                        </tr>

                                        <tr>
                                            <td>Date of Joining:</td>
                                            <td>{!! \Carbon\Carbon::parse($emp_info->professional->joining_date)->format('d-M-Y') !!}</td>
                                        </tr>
                                @if(isset($emp_info->professional->status_change_date))
                                        <tr>
                                            <td>Date of End:</td>
                                            <td>{!! \Carbon\Carbon::parse($emp_info->professional->status_change_date)->format('d-M-Y') !!}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Blood Group:</td>
                                            <td>{!! $emp_info->blood_group !!}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div  class="panel panel-default">

                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="col-md-6 col-lg-6 " align="center">
                                                    <table class="table table-danger">

                                                        <tr>
                                                            <td>Father's Name:</td>
                                                            <td>{!! $emp_info->father_name !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Mother's Name:</td>
                                                            <td>{!! $emp_info->mother_name !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Present Address:</td>
                                                            <td>{!! nl2br(e($emp_info->pr_address)) !!}<br/> District : {!! $emp_info->pr_district !!} <br/> PS : {!! $emp_info->pr_police_station !!} <br/> Post Code: {!! $emp_info->pr_post_code !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Permanent Address:</td>
                                                            <td>{!! nl2br(e($emp_info->pm_address)) !!}<br/> District : {!! $emp_info->pm_district !!} <br/> PS : {!! $emp_info->pm_police_station !!} <br/> Post Code: {!! $emp_info->pm_post_code !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mailing Address:</td>
                                                            <td>{!! nl2br(e($emp_info->pr_address)) !!}<br/> District : {!! $emp_info->m_district !!} <br/> PS : {!! $emp_info->m_police_station !!} <br/> Post Code: {!! $emp_info->m_post_code !!}  </td>
                                                        </tr>
                                                    </table>

                                                </div>

                                                <div class=" col-md-6 col-lg-6 ">
                                                    <table class="table table-secondary">
                                                        <tbody>


                                                        <tr>
                                                            <td>Phone:</td>
                                                            <td>{!! $emp_info->phone !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Mobile:</td>
                                                            <td>{!! $emp_info->mobile !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Speciality:</td>
                                                            <td>{!! $emp_info->prof_speciality !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Gender:</td>
                                                            <td>{!! $emp_info->gender !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>National ID:</td>
                                                            <td>{!! $emp_info->national_id !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Highest Degree:</td>
                                                            <td>{!! $emp_info->last_education !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Short Biography:</td>
                                                            <td>{!! $emp_info->biography !!}</td>
                                                        </tr>


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="tab-pane fade" id="pills-official" role="tabpanel" aria-labelledby="pills-official-tab">

                                    @if(isset($emp_info->professional->employee_id))

                                        <table class="table table-bordered table-primary">
                                            <tr>
                                                <td>Employee ID:</td>
                                                <td>{!! $emp_info->professional->employee_id !!}</td>
                                            </tr>

                                            <tr>
                                                <td>Joining Date:</td>
                                                <td>{!! $emp_info->professional->joining_date !!}</td>
                                            </tr>

                                            <tr>
                                                <td>Joining Status</td>
                                                <td>{!! $emp_info->professional->confirm_probation == 'P' ? $emp_info->confirm_period.' Months Probation' : ($emp_info->professional->confirm_probation == 'D' ? $emp_info->confirm_period.' Contractual' : 'Confirm' ) !!}</td>
                                            </tr>

                                            <tr>
                                                <td>Working Status:</td>
                                                <td>{!! $emp_info->professional->wStatus->name !!}</td>
                                            </tr>
                                            <tr>
                                                <td>PF No</td>
                                                <td>{!! $emp_info->professional->pf_no !!}</td>
                                            </tr>

                                            <tr>
                                                <td>Punch Exempt</td>
                                                <td>{!! $emp_info->professional->punch_exempt == true ? 'Yes' : 'No' !!}</td>
                                            </tr>

                                        </table>
                                    @endif
                                </div>

                                {{--Dependant TAb--}}

                                <div class="tab-pane fade" id="pills-dependant" role="tabpanel" aria-labelledby="pills-dependant-tab">

                                    <table class="table table-bordered table-success">

                                        <thead>
                                        <tr>
                                            <th>Relation</th>
                                            <th>Name</th>
                                            <th>Birth Date</th>
                                            <th>Age</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($emp_info->dependant as $dep)
                                                <tr>
                                                    <td>{!! $dep->dependant_type == 'F' ? 'Father' : ($dep->dependant_type == 'M' ? 'Mother' : ($dep->dependant_type == 'P' ? 'Spouse' : 'Son')) !!}</td>
                                                    <td>{!! $dep->name !!}</td>
                                                    <td>{!! $dep->date_of_birth !!}</td>
                                                    <td>{!! $dep->age !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>


                                <div class="tab-pane fade" id="pills-posting" role="tabpanel" aria-labelledby="pills-posting-tab">

                                    <table class="table table-bordered table-info">

                                        <thead>
                                        <tr>
                                            <th>Division</th>
                                            <th>Department</th>
                                            <th>Section</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Charge</th>
                                            <th>Report To</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($emp_info->posting as $row)
                                            <tr>
                                                <td>{!! $row->division->short_name !!}</td>
                                                <td>{!! $row->department->short_name !!}</td>
                                                <td>{!! isset($row->section_id) ? $row->section->short_name : " " !!}</td>
                                                <td>{!! $row->posting_start_date !!}</td>
                                                <td>{!! $row->posting_end_date !!}</td>
                                                <td>{!! $row->charge_type == 'I' ? 'In Charge' : ($row->charge_type == 'S' ? '2nd Man' : 'General') !!}</td>
                                                <td>{!! $row->report->full_name !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <div class="tab-pane fade" id="pills-education" role="tabpanel" aria-labelledby="pills-education-tab">

                                    <table class="table table-bordered table-success">

                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Institution</th>
                                            <th>Type</th>
                                            <th>Passing Year</th>
                                            <th>Result</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($emp_info->education as $dep)
                                            <tr>
                                                <td>{!! $dep->name !!}</td>
                                                <td>{!! $dep->institution !!}</td>
                                                <td>{!! $dep->degree_type == 'A' ? 'Academic' : ($dep->degree_type == 'P' ? 'Professional' : 'Others') !!}</td>
                                                <td>{!! $dep->passing_year !!}</td>
                                                <td>{!! $dep->result !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>




                                <div class="tab-pane fade" id="pills-leave" role="tabpanel" aria-labelledby="pills-leave-tab">

                                    <table class="table table-bordered table-success">

                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Days</th>
                                            <th>Location</th>
                                            <th>Alternate</th>
                                            <th>Status</th>
                                            <th>Print</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($emp_info->leaveApp as $app)
                                            <tr>
                                                <td>{!! $app->type->name !!} <br> {!! $app->leave_id == 3 ? $app->duty_date : null !!}</td>
                                                <td>{!! $app->from_date !!} <br/>{!! $app->to_date !!}</td>
                                                <td>{!! $app->nods !!}</td>
                                                <td>{!! $app->location !!}</td>
                                                <td>{!! $app->alternate_id !!}</td>
                                                <td>{!! $app->status == 'D' ? 'Rejected' : ($app->status == 'C' ? 'Applied' : ($app->status == 'R' ? 'Recommended' : ($app->status == 'K' ? 'Acknowledged' : ($app->status == 'A' ? 'Approved' : 'Canceled')))) !!}</td>
                                                <td><a href="{!! $app->status == 'A' ? url('employee/leave/print/'.$app->id) : '#' !!}"><i class="fa fa-print"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>




                                    <table class="table table-bordered table-info">

                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Limit</th>
                                            <th>Enjoyed</th>
                                            <th>Balance</th>
                                            <th>Last On</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($emp_info->leave as $leave)
                                            <tr>
                                                <td>{!! $leave->type->name !!}</td>
                                                <td>{!! $leave->leave_eligible !!}</td>
                                                <td>{!! $leave->leave_enjoyed !!}</td>
                                                <td>{!! $leave->leave_balance !!}</td>
                                                <td>{!! $leave->last_leave !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>




                                </div>




                                <div class="tab-pane fade" id="pills-promotion" role="tabpanel" aria-labelledby="pills-promotion-tab">

                                    <table class="table table-bordered table-info">

                                        <thead>
                                        <tr>
                                            <th>Effective Date</th>
                                            <th>Designation</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($emp_info->promotion as $prm)
                                            <tr>
                                                <td>{!! $prm->effective_date !!}</td>
                                                <td>{!! $prm->designation->name !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>



                                <div class="tab-pane fade" id="pills-training" role="tabpanel" aria-labelledby="pills-training-tab">

                                    <table class="table table-bordered table-info">

                                        <thead>
                                        <tr>
                                            <th>Training</th>
                                            <th>Schedule</th>
                                            <th>Status</th>
                                            <th>Evaluation</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($emp_info->professional->trainees as $prm)
                                            <tr>
                                                <td>{!! $prm->trainingSch->training->title !!}</td>
                                                <td>{!! $prm->trainingSch->start_from .' TO '.$prm->trainingSch->end_on  !!}</td>
                                                <td>{!! $prm->attended == true ? 'Atteded' : null  !!}</td>
                                                <td>{!! $prm->evaluation !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>



                                {{--End Tabs--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!--/.Container-->


@endsection

@push('scripts')
    <script>
        (function () {
            'use strict';

            if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement('style');
                msViewportStyle.appendChild(
                    document.createTextNode(
                        '@-ms-viewport{width:auto!important}'
                    )
                );
                document.head.appendChild(msViewportStyle)
            }

        }())
    </script>
@endpush