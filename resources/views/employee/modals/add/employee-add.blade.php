<div class="modal fade right" id="modal-new-employee" tabindex="-1" role="dialog" aria-labelledby="modal-new-employee-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info modal-lg" role="document">
        <!--Content-->


            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Employee Information
                    </p>

                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true" class="white-text">&times;</span>--}}
                    {{--</button>--}}
                </div>

                <!--Body-->
                <div class="modal-body">



                    <div class="wrapper">
                        <ul class="tabs clearfix" data-tabgroup="first-tab-group">
                            <li><a href="#tab1" class="active">Personal</a></li>
                            <li><a href="#tab2">Professional</a></li>
                        </ul>

                        <section id="first-tab-group" class="tabgroup">

                            <div id="tab1">

                                {{--<form class="form-horizontal" id="personal-form" role="form" method="POST" action="" accept-charset="UTF-8">--}}
                                    <h2>Personal Data</h2>

                                    {{--{{ csrf_field() }}--}}

                                    <input type="hidden" id="update_emp_id" name="update_emp_id" class="form-control" />

                                    <div class="row">
                                        <div class="col-md-6">


                                            <div class="container-fluid">

                                                {{--<div class="form-group row">--}}
                                                    {{--<label for="title_id" class="col-sm-3 col-form-label">Title</label>--}}
                                                    {{--<div class="col-sm-9">--}}
                                                        {{--{!! Form::select('title_id',$titles,null,array('id'=>'title_id','class'=>'form-control','autofocus','placeholder'=>'Please Select')) !!}--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}


                                                <div class="form-group row required">
                                                    <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="first_name" id="first_name" class="form-control" required value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="middle_name" class="col-sm-3 col-form-label">Middle Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="middle_name" id="middle_name" class="form-control" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="last_name" id="last_name" class="form-control" value="" />
                                                    </div>
                                                </div>


                                                <div class="form-group row required">
                                                    <label for="pr_address" class="col-sm-3 col-form-label">Present Address</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="pr_address" cols="50" rows="2" id="pr_address" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="pr_district" class="col-sm-3 col-form-label">Present District</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('pr_district',$districts,null,array('id'=>'pr_district','class'=>'form-control')) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="pr_police_station" class="col-sm-3 col-form-label">Police Station</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="pr_police_station" class="form-control" id="pr_police_station" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="pr_post_code" class="col-sm-3 col-form-label">Pr Post Code</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('pr_post_code',$posts,null,array('id'=>'pr_post_code','class'=>'form-control')) !!}
                                                    </div>
                                                </div>


                                                <div class="form-group row required">
                                                    <label for="pm_address" class="col-sm-3 col-form-label">Permanent Address</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="pm_address" cols="50" rows="2" id="pm_address" placeholder="Permanent Address" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="pm_district" class="col-sm-3 col-form-label">Permanent District</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('pm_district',$districts,null,array('id'=>'pm_district','class'=>'form-control')) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="pm_police_station" class="col-sm-3 col-form-label">Police Station</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="pm_police_station" class="form-control" id="pm_police_station" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="pm_post_code" class="col-sm-3 col-form-label">Permanent Post Code</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('pm_post_code',$posts,null,array('id'=>'pm_post_code','class'=>'form-control')) !!}
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="m_address" class="col-sm-3 col-form-label">Mailing Address</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="m_address" cols="50" rows="2" id="m_address">{!! $company->name !!} {!! $company->address !!}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="m_district" class="col-sm-3 col-form-label">Mailing District</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('m_district',$districts, $dhaka->district, array('id'=>'m_district','class'=>'form-control')) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="m_police_station" class="col-sm-3 col-form-label">Police Station</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="m_police_station" class="form-control" id="m_police_station" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="m_post_code" class="col-sm-3 col-form-label">Mailing Post Code</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('m_post_code',$posts,$dhaka->post_code,array('id'=>'m_post_code','class'=>'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="container-fluid">

                                                <div class="form-group row required">
                                                    <label for="father_name" class="col-sm-3 col-form-label">Father's Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="father_name" class="form-control" id="father_name" required placeholder="Father's Name" value="" />
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="mother_name" class="col-sm-3 col-form-label">Mother's Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="mother_name" class="form-control" id="mother_name" required placeholder="Mother's Name" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="spouse_name" class="col-sm-3 col-form-label">Spouse Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="spouse_name" class="form-control" id="spouse_name" required placeholder="Spouse's Name" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('gender',['M' => 'Male', 'F' => 'Female','O'=>'Others'],null,array('id'=>'gender','class'=>'form-control')) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="religion_id" class="col-sm-3 col-form-label">Religion</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('religion_id',$religions,null,array('id'=>'religion_id','class'=>'form-control')) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="prof_speciality" class="col-sm-3 col-form-label">Speciality</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="prof_speciality" id="prof_speciality" class="form-control" placeholder="Professional Speciality" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="email" class="col-sm-3 col-form-label">E Mail</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" name="email" class="form-control" id="email" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="phone" class="form-control" id="phone" value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="mobile" class="form-control" id="mobile" required value="" />
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" name="dob" class="form-control" id="dob" required value="" />
                                                    </div>
                                                </div>

                                                <div class="form-group row required">
                                                    <label for="blood_group" class="col-sm-3 col-form-label">Blood Group</label>
                                                    <div class="col-sm-9">
                                                     {!! Form::select('blood_group',['A+' => 'A+', 'A-' => 'A-','B+'=>'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'],null,array('id'=>'blood_group','class'=>'form-control','placeholder' => 'Select Blood Group')) !!}


                                                       
                                                    </div>
                                                </div>



                                                <div class="form-group row">
                                                    <label for="last_education" class="col-sm-3 col-form-label">Highest Degree</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="last_education" class="form-control" id="last_education" value="" />
                                                    </div>
                                                </div>
<div class="form-group row">
        <label for="education_year" class="col-sm-3 col-form-label">Passing Year</label>
         <div class="col-sm-9">
        <input type="text" name="education_year" class="form-control" id="education_year" value="" /> 
</div>
  </div>

                                                <div class="form-group row">
                                                    <label for="biography" class="col-sm-3 col-form-label">Short Biography</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" name="biography" cols="50" rows="2" id="biography" placeholder="Short Biography"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="national_id" class="col-sm-3 col-form-label">National/<br/>Birth Id</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="national_id" class="form-control" id="national_id" value="" />
                                                    </div>
                                                </div>

                                                <input type="hidden" name="action" id="action" class="form-control" value="personal" />

                                            </div>

                                            <button type="submit" id="btn-personal" class="btnRegister btn-personal">Submit</button>

                                        </div>

                                    </div>

                                {{--</form>--}}
                            </div>


                            <div id="tab2">

                                <h2 style="text-align: center" id="pro_emp_name"></h2>

                                {{--{{ csrf_field() }}--}}

                                <input type="hidden" id="emp_personals_id" name="emp_personals_id" class="form-control" />

                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="container-fluid">

                                            <div class="form-group row">
                                                <label for="employee_id" class="col-sm-3 col-form-label">Employee ID</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="employee_id" id="employee_id" class="form-control" required value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="designation_id" class="col-sm-3 col-form-label">Designation</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('designation_id',$designations,null,array('id'=>'designation_id','class'=>'form-control')) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="joining_date" class="col-sm-3 col-form-label">Joining Date</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="joining_date" id="joining_date" class="form-control" required />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="pf_no" class="col-sm-3 col-form-label">PF No</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="pf_no" id="pf_no" class="form-control" required/>
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="transport" class="col-sm-3 col-form-label">Transport</label>
                                                <div class="col-sm-9">

                                                    <div class="form-group">
                                                        <div class="maxl">
                                                            <label class="radio inline">
                                                                <input type="radio" id="transport-y" name="transport" value="{!! 1 !!}">
                                                                <span style="color: #0a0a0a">Yes</span>
                                                            </label>
                                                            <label class="radio inline">
                                                                <input type="radio" id="transport-n" name="transport" value="{!! 0 !!}" checked>
                                                                <span style="color: #0a0a0a">No</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="transport_note" class="col-sm-3 col-form-label">Transport Instructions</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="transport_note" cols="50" rows="4" id="transport_note"></textarea>
                                                </div>
                                            </div>



                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="container-fluid">

                                            <div class="form-group row">
                                                <label for="confirm_probation" class="col-sm-3 col-form-label">Joining Status</label>
                                                <div class="col-sm-9">

                                                    <div class="form-group">
                                                        <div class="maxl">
                       
                                                            <label class="radio inline">
                                                                <input type="radio" id="confirm_probation" name="confirm_probation" value= "P" checked>
                                                                <span style="color: #0a0a0a">Probation</span>
                                                            </label>
                                                            <label class="radio inline">
                                                                <input type="radio" id="confirm_probation" name="confirm_probation" value= "D" >
                                                                <span style="color: #0a0a0a"> Contractual </span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="confirm_period" class="col-sm-6 col-form-label">Confirmation/Contractual Period (Months)</label>
                                                <div class="col-sm-6">
                                                    {!! Form::selectRange('confirm_period', 1, 36,6,array('id'=>'confirm_period','class'=>'form-control')) !!}
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <label for="contractEnd_date" class="col-sm-3 col-form-label">Contract End Date</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="contractEnd_date" id="contractEnd_date" class="form-control"  />
                                                </div>
                                            </div> --}}

                                            <div class="form-group row">
                                                <label for="overtime" class="col-sm-3 col-form-label">Overtime</label>
                                                <div class="col-sm-9">

                                                    <div class="form-group">
                                                        <div class="maxl">
                                                            <label class="radio inline">
                                                                <input type="radio" id="overtime-y" name="overtime" value="{!! 1 !!}">
                                                                <span style="color: #0a0a0a">Yes</span>
                                                            </label>
                                                            <label class="radio inline">
                                                                <input type="radio" id="overtime-n" name="overtime" value="{!! 0 !!}" checked>
                                                                <span style="color: #0a0a0a">No</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="overtime_note" class="col-sm-3 col-form-label">OT Instructions</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="overtime_note" cols="50" rows="4" id="overtime_note"></textarea>
                                                </div>
                                            </div>

                                            {{--<input type="hidden" name="action" id="action" class="form-control" value="professional" />--}}

                                        </div>

                                        <button type="submit" name="action" id="official" value="official" class="btnRegister btn-official">Submit</button>

                                    </div>

                                </div>

                            </div>

                        </section>
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
                </div>



            </div>
            <!--/.Content-->
    </div>
</div>
<!-- Modal: modalAbandonedCart-->

<script>





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

    $('.custom-image-file-input').on('change',function(){
        var fileName = document.getElementById("emp_image").files[0].name;
        $(this).next('.form-control-image-file').addClass("selected").html(fileName);
    });

    $('.custom-sign-file-input').on('change',function(){
        var fileName = document.getElementById("emp_sign").files[0].name;
        $(this).next('.form-control-sign-file').addClass("selected").html(fileName);
    });

    function name_validation(uid_len,mx,my,r_input)
    {
        // var uid_len = uid.value.length;
        if (uid_len == 0 || uid_len >= my || uid_len < mx)
        {
            alert(r_input+ " should not be empty / length be between "+mx+" to "+my);
            // uid.focus();
            return false;
        }else
        return true;
    }


    $(document).on('click', '.btn-personal', function (e) {
        e.preventDefault();

        // name_validation(document.getElementById('first_name').value.length,5,100,'First Name');
        // name_validation(document.getElementById('father_name').value.length,5,100,'Father Name');
        // name_validation(document.getElementById('mobile').value.length,5,100,'Mobile No');




        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = 'personal/save';

        // confirm then
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',

            data: {method: '_POST', submit: true,
                title_id:$('#title_id').val(),
                first_name:$('#first_name').val(),
                middle_name:$('#middle_name').val(),
                last_name:$('#last_name').val(),
                email:$('#email').val(),
                pr_address:$('#pr_address').val(),
                pr_district:$('#pr_district').val(),
                pr_police_station:$('#pr_police_station').val(),
                pr_post_code:$('#pr_post_code').val(),
                biography:$('#biography').val(),
                blood_group:$('#blood_group').val(),
                dob:$('#dob').val(),
                religion_id:$('#religion_id').val(),
                father_name:$('#father_name').val(),
                last_education:$('#last_education').val(),
                education_year:$('#education_year').val(),
                gender:$('#gender').val(),
                mobile:$('#mobile').val(),
                mother_name:$('#mother_name').val(),
                spouse_name:$('#spouse_name').val(),
                m_address:$('#m_address').val(),
                m_district:$('#m_district').val(),

                m_police_station:$('#m_police_station').val(),

                m_post_code:$('#m_post_code').val(),
                national_id:$('#national_id').val(),
                phone:$('#phone').val(),
                pm_address:$('#pm_address').val(),
                pm_police_station:$('#pm_police_station').val(),
                pm_district:$('#pm_district').val(),
                pm_post_code:$('#pm_post_code').val(),
                prof_speciality:$('#prof_speciality').val(),
                action:$('#action').val(),
            },

            error: function (request, status, error) {
                alert(request.responseText);
            },

            success: function (data) {

                alert('Employee Personal Information Added');

                $("input[type=text], textarea").val("");

                document.getElementById('pro_emp_name').innerText='Enter Professional Data For : ' + data.full_name;
                document.getElementById('emp_personals_id').value= data.id;
                document.getElementById('per_emp_id').innerText= data.id;



                $('#employees-table').DataTable().draw(false);

            }

        });
    });




//    Save Professional Information

    $(document).on('click', '.btn-official', function (e) {
        e.preventDefault();



        // name_validation(document.getElementById('first_name').value.length,5,100,'First Name');
        // name_validation(document.getElementById('father_name').value.length,5,100,'First Name');
        // name_validation(document.getElementById('mobile').value.length,5,100,'Mobile No');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = 'professional/save';

        // confirm then
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',

            data: {method: '_POST', submit: true,
                confirm_period:$('#confirm_period').val(),
                confirm_probation:$('#confirm_probation:checked').val(),
                designation_id:$('#designation_id').val(),
                employee_id:$('#employee_id').val(),
                emp_personals_id:$('#emp_personals_id').val(),
                joining_date:$('#joining_date').val(),
                pf_no:$('#pf_no').val(),
                section_id:$('#section_id').val(),
                action:$('#official').val(),
            },

            error: function (request, status, error) {
                alert(request.responseText);
            },

            success: function (data) {

                $("input[type=text], textarea").val("");

                alert('Employee Professional Information Added');

                // document.getElementById('edu_emp_name').innerText='Enter Education Data For : ' + data.full_name;

                $('#employees-table').DataTable().draw(false);
                $('#modal-new-employee').modal('hide');

            }

        });
    });


    $("input").on("change", function() {
        this.setAttribute(
            "data-date",
            moment(this.value, "YYYY-MM-DD")
                .format( this.getAttribute("data-date-format") )
        )
    }).trigger("change")


</script>