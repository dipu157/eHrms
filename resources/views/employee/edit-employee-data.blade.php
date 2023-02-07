@extends('layouts.master')

@section('pagetitle')
<h2 class="no-margin-bottom">Employee Personal & Official Information Update</h2>
@endsection
@section('content')
<script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
<link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">
                <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
            </div>
        </div>
    </div>


    <div class="wrapper">
        <ul class="tabs clearfix" data-tabgroup="first-tab-group">
            <li><a href="#tab1" class="active">Personal</a></li>
            <li><a href="#tab2">Professional</a></li>
            <li><a href="#tab3">Job Status</a></li>
        </ul>

        <section id="first-tab-group" class="tabgroup">

            <div id="tab1">

                <form class="form-horizontal" id="personal-form" role="form" method="POST" action="" accept-charset="UTF-8">
                    <h2>Personal Data</h2>

                    {{ csrf_field() }}

                    <input type="hidden" id="id" name="id" value="{!! $data->id !!}" class="form-control" />

                    <div class="row">
                        <div class="col-md-6">


                            <div class="container-fluid">

                                {{--<div class="form-group row">--}}
                                {{--<label for="title_id" class="col-sm-3 col-form-label">Title</label>--}}
                                {{--<div class="col-sm-9">--}}
                                {{-- Form::select('title_id',$titles,$data->title_id,array('id'=>'title_id','class'=>'form-control','autofocus','placeholder'=>'Please Select')) --}}
                                {{--</div>--}}
                                {{--</div>--}}


                                <div class="form-group row">
                                    <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="first_name" id="first_name" class="form-control" required value="{!! $data->first_name !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="middle_name" class="col-sm-3 col-form-label">Middle Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="middle_name" id="middle_name" class="form-control" value="{!! $data->middle_name !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{!! $data->last_name !!}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="pr_address" class="col-sm-3 col-form-label">Present Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="pr_address" cols="50" rows="2" id="pr_address" required>{!! $data->pr_address !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pr_district" class="col-sm-3 col-form-label">Present District</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('pr_district',$districts,$data->pr_district,array('id'=>'pr_district','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pr_post_code" class="col-sm-3 col-form-label">Pr Post Code</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('pr_post_code',$posts,$data->pr_post_code,array('id'=>'pr_post_code','class'=>'form-control')) !!}
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="pm_address" class="col-sm-3 col-form-label">Permanent Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="pm_address" cols="50" rows="2" id="pm_address" placeholder="Permanent Address" required>{!! $data->pm_address !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pm_district" class="col-sm-3 col-form-label">Permanent District</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('pm_district',$districts,$data->pm_district,array('id'=>'pm_district','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pm_post_code" class="col-sm-3 col-form-label">Permanent Post Code</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('pm_post_code',$posts,$data->pm_post_code,array('id'=>'pm_post_code','class'=>'form-control')) !!}
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="m_address" class="col-sm-3 col-form-label">Mailing Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="m_address" cols="50" rows="2" id="m_address" placeholder="Mailing Address">{!! $data->m_address !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="m_district" class="col-sm-3 col-form-label">Mailing District</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('m_district',$districts,$data->m_district,array('id'=>'m_district','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="m_post_code" class="col-sm-3 col-form-label">Mailing Post Code</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('m_post_code',$posts,$data->m_post_code,array('id'=>'m_post_code','class'=>'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="container-fluid">

                                <div class="form-group row">
                                    <label for="father_name" class="col-sm-3 col-form-label">Father's Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="father_name" class="form-control" id="father_name" required placeholder="Father's Name" value="{!! $data->father_name !!}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="mother_name" class="col-sm-3 col-form-label">Mother's Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="mother_name" class="form-control" id="mother_name" required placeholder="Mother's Name" value="{!! $data->mother_name !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('gender',['M' => 'Male', 'F' => 'Female','O'=>'Others'],$data->gender,array('id'=>'gender','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="religion_id" class="col-sm-3 col-form-label">Religion</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('religion_id',$religions,$data->religion_id,array('id'=>'religion_id','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="prof_speciality" class="col-sm-3 col-form-label">Speciality</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="prof_speciality" id="prof_speciality" class="form-control" value="{!! $data->prof_speciality !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">E Mail</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" id="email" value="{!! $data->email !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" class="form-control" id="phone" value="{!! $data->phone !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="mobile" class="form-control" id="mobile" required value="{!! $data->mobile !!}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="dob" class="form-control" id="dob" required value="{!! $data->dob !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="blood_group" class="col-sm-3 col-form-label">Blood Group</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('blood_group',['A+' => 'A+', 'A-' => 'A-','B+'=>'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'],$data->blood_group,array('id'=>'u_blood_group','class'=>'form-control','placeholder' => 'Select Blood Group')) !!}

                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="last_education" class="col-sm-3 col-form-label">Highest Degree</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_education" class="form-control" id="last_education" value="{!! $data->last_education !!}" />
                                    </div>
                                </div>
<div class="form-group row">
 <label for="last_education" class="col-sm-3 col-form-label">Passing Year</label>
   <div class="col-sm-9">
  <input type="text" name="education_year" class="form-control" id="education_year" value="{!! $data->education_year !!}" />
            </div>
          </div>

                                <div class="form-group row">
                                    <label for="biography" class="col-sm-3 col-form-label">Short Biography</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="biography" cols="50" rows="2" id="biography">{!! $data->biography !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="national_id" class="col-sm-3 col-form-label">National Id</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="national_id" class="form-control" id="national_id" value="{!! $data->national_id !!}" />
                                    </div>
                                </div>

                                <input type="hidden" name="action" id="action" class="form-control" value="personal" />

                            </div>

                            <button type="submit" id="btn-personal" class="btnRegister btn-personal">Submit</button>

                        </div>

                    </div>

                </form>
            </div>


            <div id="tab2">
                <h2 style="text-align: center; color: #0a0a0a">Official Data</h2>

                <form class="form-horizontal" id="professional-form" role="form" method="POST" action="">

                    @if(isset($data->professional->id))
                    <input type="hidden" id="id" name="id" value="{!! $data->professional->id !!}" class="form-control" />
                    @endif

                    <input type="hidden" id="emp_personals_id" name="emp_personals_id" value="{!! $data->id !!}" class="form-control" />

                    <div class="row">
                        <div class="col-md-6">


                            <div class="container-fluid">

                                <div class="form-group row">
                                    <label for="employee_id" class="col-sm-3 col-form-label">Employee ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="employee_id" id="employee_id" class="form-control" required value="{!! isset($data->professional->employee_id) ? $data->professional->employee_id : null !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="base_designation_id" class="col-sm-3 col-form-label">Base Designation</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('base_designation_id',$base_designations, isset($data->professional->base_designation_id) ? $data->professional->base_designation_id : null, array('id'=>'base_designation_id','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="designation_id" class="col-sm-3 col-form-label">Designation</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('designation_id',$designations, isset($data->professional->designation_id) ? $data->professional->designation_id : null, array('id'=>'designation_id','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="joining_date" class="col-sm-3 col-form-label">Joining Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="joining_date" id="joining_date" class="form-control" value="{!! isset($data->professional->joining_date) ? $data->professional->joining_date : null !!}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pf_no" class="col-sm-3 col-form-label">PF No</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="pf_no" value="{!! isset($data->professional->pf_no) ? $data->professional->pf_no : null !!}" id="pf_no" class="form-control" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_id" class="col-sm-3 col-form-label">Bank</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('bank_id',$banks, isset($data->professional->bank_id) ? $data->professional->bank_id : null,array('id'=>'bank_id','class'=>'form-control','placeholder'=>'Select Bank')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bank_acc_no" class="col-sm-3 col-form-label">Bank Account</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bank_acc_no" id="bank_acc_no" class="form-control" value="{!! isset($data->professional->bank_acc_no) ? $data->professional->bank_acc_no : null !!}" />

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="overtime" class="col-sm-3 col-form-label">Overtime</label>
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <div class="maxl">
                                                <label class="radio inline">
                                                    <input type="radio" id="overtime-y" name="overtime" value="{!! 1 !!}" {!! $data->professional->overtime == true ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">Yes</span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="overtime-n" name="overtime" value="{!! 0 !!}" {!! $data->professional->overtime == false ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">No</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="overtime_note" class="col-sm-3 col-form-label">OT Instructions</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="overtime_note" cols="50" rows="4" id="overtime_note">{!! $data->professional->overtime_note !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="doctor_special_id" class="col-sm-3 col-form-label">Doctor Special</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('doctor_special_id',['1' => 'Professor', '2' => 'Register','3'=>'Specialist', '4' => 'Consultant', '5' => 'Doctor Incharge', '6' => 'Doctor'],$data->doctor_special_id,array('id'=>'professional_id','class'=>'form-control','placeholder' => 'Select ')) !!}

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="doctor_department_id" class="col-sm-3 col-form-label">Doctor Department</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('doctor_department_id',$doctorDepartments, isset($data->professional->doctor_department_id) ? $data->professional->doctor_department_id : null, array('id'=>'doctor_department_id','class'=>'form-control')) !!}
                                    </div>
                                </div>


                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="container-fluid">

                                <div class="form-group row">
                                    <label for="father_name" class="col-sm-3 col-form-label">Joining Status</label>
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <div class="maxl">
                                                <label class="radio inline">
                                                    <input type="radio" id="confirm_probation" name="confirm_probation" value="P" {!! $data->professional->confirm_probation == 'P' ? 'checked' : '' !!} >
                                                    <span style="color: #0a0a0a">Probation</span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="confirm_probation" name="confirm_probation" value="C" {!! $data->professional->confirm_probation == 'C' ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a"> Confirm </span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="confirm_probation" name="confirm_probation" value="D" {!! $data->professional->confirm_probation == 'D' ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a"> Contractual </span>
                                                </label>

                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="confirm_period" class="col-sm-6 col-form-label">Confirmation Period (Months)</label>
                                    <div class="col-sm-6">
                                        {!! Form::selectRange('confirm_period', 0, 36, $data->professional->confirm_period,array('id'=>'confirm_period','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="joining_date" class="col-sm-3 col-form-label">Contract End Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="contractEnd_date" id="contractEnd_date" class="form-control" value="{!! isset($data->professional->contractEnd_date) ? $data->professional->contractEnd_date : null !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="card_no" class="col-sm-3 col-form-label">Id Card No</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="card_no" id="card_no" class="form-control" value="{!! $data->professional->card_no !!}" />

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="working_status_id" class="col-sm-3 col-form-label">Working Status</label>
                                    <div class="col-sm-9">

                                        {{--<div class="form-check">--}}
                                        {{--<input type="checkbox" class="form-check-input" id="exampleCheck1" {!! $data->professional->confirm_probation == 'P' ? 'checked' : '' !!}>--}}
                                        {{--</div>--}}

                                        {!! Form::select('working_status_id',$working,$data->professional->working_status_id,array('id'=>'working_status_id','class'=>'form-control')) !!}

                                        {{--<input type="text" name="working_status_id" id="working_status_id" class="form-control" value="{!! $data->professional->working_status_id !!}" required />--}}

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="punch_exempt" class="col-sm-3 col-form-label">Punch Exempt</label>
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <div class="maxl">
                                                <label class="radio inline">
                                                    <input type="radio" id="punch_exempt-y" name="punch_exempt" value="{!! 1 !!}" {!! $data->professional->punch_exempt == 1 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">Yes</span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="punch_exempt-n" name="punch_exempt" value="{!! 0 !!}" {!! $data->professional->punch_exempt == 0 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="late_exempt" class="col-sm-3 col-form-label">Late Exempt</label>
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <div class="maxl">
                                                <label class="radio inline">
                                                    <input type="radio" id="late_exempt-y" name="late_exempt" value="{!! 1 !!}" {!! $data->professional->late_exempt == 1 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">Yes</span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="late_exempt-n" name="late_exempt" value="{!! 0 !!}" {!! $data->professional->late_exempt == 0 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="transport" class="col-sm-3 col-form-label">Transport</label>
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <div class="maxl">
                                                <label class="radio inline">
                                                    <input type="radio" id="transport-y" name="transport" value="{!! 1 !!}" {!! $data->professional->transport == 1 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">Yes</span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="transport-n" name="transport" value="{!! 0 !!}" {!! $data->professional->transport == 0 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">No</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="transport_note" class="col-sm-3 col-form-label">Transport Instructions</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="transport_note" cols="50" rows="4" id="transport_note">{!! $data->professional->transport_note !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label">Base Designation</label>
                                    <div class="col-sm-9">

                                        <div class="form-group">
                                            <div class="maxl">
                                                <label class="radio inline">
                                                    <input type="radio" id="status-y" name="status" value="{!! 1 !!}" {!! $data->professional->status == 1 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">Yes</span>
                                                </label>
                                                <label class="radio inline">
                                                    <input type="radio" id="status-n" name="status" value="{!! 0 !!}" {!! $data->professional->status == 0 ? 'checked' : '' !!}>
                                                    <span style="color: #0a0a0a">No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="action" id="action" class="form-control" value="professional" />

                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab3">
                <h2 style="text-align: center; color: #0a0a0a">Job Status</h2>

                <form class="form-horizontal" id="job-status-form" role="form" method="POST" action="">

                    @if(isset($data->professional->id))
                    <input type="hidden" id="id" name="id" value="{!! $data->professional->id !!}" class="form-control" />
                    @endif

                    <input type="hidden" id="emp_personals_id" name="emp_personals_id" value="{!! $data->id !!}" class="form-control" />

                    <div class="row">
                        <div class="col-md-10">


                            <div class="container-fluid">


                                <div class="form-group row">
                                    <label for="status_id" class="col-sm-3 col-form-label">Change Status</label>
                                    <div class="col-sm-9">
                                        {!! Form::select('status_id',$working, isset($data->professional->working_status_id) ? $data->professional->working_status_id : null, array('id'=>'status_id','class'=>'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-3 col-form-label">Effective From</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required />
                                    </div>
                                </div>

                                <div class="form-group row" name="hidden-panel" id="hidden-panel">
                                    <label for="to_date" class="col-sm-3 col-form-label">Effective To</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="to_date" id="to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="change_notes" class="col-sm-3 col-form-label">Change Notes</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="change_notes" cols="50" rows="4" id="change_notes"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="descriptions" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="descriptions" cols="50" rows="4" id="descriptions"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="action" id="action" class="form-control" value="job-status" />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

</div>
<!--/.Container-->


@endsection

@push('scripts')
<script>
    $('.tabgroup > div').hide();
    $('.tabgroup > div:first-of-type').show();
    $('.tabs a').click(function(e) {
        e.preventDefault();
        var $this = $(this),
            tabgroup = '#' + $this.parents('.tabs').data('tabgroup'),
            others = $this.closest('li').siblings().children('a'),
            target = $this.attr('href');
        others.removeClass('active');
        $this.addClass('active');
        $(tabgroup).children('div').hide();
        $(target).show();

    });


    $('#personal-form').on("submit", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = 'personal/update';
        // confirm then

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),

            error: function(request, status, error) {
                alert(request.responseText);
            },

            success: function(data) {

                alert('Data Successfully Updated');
            },

        })

    });


    $('#professional-form').on("submit", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = 'professional/update';
        // confirm then

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),

            error: function(request, status, error) {
                alert(request.responseText);
            },

            success: function(data) {

                alert('Data Successfully Updated');
            },

        })

    });


    $('#job-status-form').on("submit", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = 'professional/update';
        // confirm then

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),

            error: function(request, status, error) {
                alert(request.responseText);
            },

            success: function(data) {

                alert('Data Successfully Updated');
            },

        })

    });

    $("#status_id").change(function() {
        if ($("#status_id").val() == 8) {
            $("#hidden-panel").show()
        } else {
            $("#hidden-panel").hide()
        }
    });
</script>




@endpush