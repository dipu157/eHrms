<div class="modal fade right" id="modal-update-employee" tabindex="-1" role="dialog" aria-labelledby="modal-update-employee-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info modal-lg" role="document">
        <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Employee Information
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">

                    <div class="wrapper">
                        <ul class="tabs clearfix" data-tabgroup="first-tab-group">
                            <li><a href="#tab1" class="active">Personal</a></li>
                            <li><a href="#tab6">Dependant</a></li>
                            <li><a href="#tab2">Profassional</a></li>
                            <li><a href="#tab3">Educations</a></li>
                            <li><a href="#tab4">Experiences</a></li>
                            <li><a href="#tab5">Posting</a></li>
                        </ul>

                        <section id="first-tab-group" class="tabgroup">

                            <div id="tab1">

                                <form class="form-horizontal" id="personal-form" role="form" method="POST" action="" accept-charset="UTF-8">
                                <h2>Personal Data</h2>

                                    {{ csrf_field() }}

                                    <input type="hidden" id="update_emp_id" name="update_emp_id" class="form-control" />

                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="container-fluid">

                                            <div class="form-group row">
                                                <label for="title_id" class="col-sm-3 col-form-label">Title</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('title_id',$titles,null,array('id'=>'u_title_id','class'=>'form-control','autofocus','placeholder'=>'Please Select')) !!}
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="first_name" id="u_first_name" class="form-control" required value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="middle_name" class="col-sm-3 col-form-label">Middle Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="middle_name" id="u_middle_name" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="last_name" id="u_last_name" class="form-control" required value="" />
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="pr_address" class="col-sm-3 col-form-label">Present Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="pr_address" cols="50" rows="4" id="u_pr_address" required></textarea>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="pm_address" class="col-sm-3 col-form-label">Permanent Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="pm_address" cols="50" rows="4" id="u_pm_address" placeholder="Permanent Address" required></textarea>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="m_address" class="col-sm-3 col-form-label">Mailing Address</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="m_address" cols="50" rows="4" id="u_m_address" placeholder="Mailing Address"></textarea>
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="prof_speciality" class="col-sm-3 col-form-label">Speciality</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="prof_speciality" id="u_prof_speciality" class="form-control" placeholder="Professional Speciality" value="" />
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('gender',['M' => 'Male', 'F' => 'Female','O'=>'Others'],null,array('id'=>'u_gender','class'=>'form-control')) !!}
                                                </div>
                                            </div>



                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="container-fluid">

                                            <div class="form-group row">
                                                <label for="father_name" class="col-sm-3 col-form-label">Father's Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="father_name" class="form-control" id="u_father_name" required placeholder="Father's Name" value="" />
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="mother_name" class="col-sm-3 col-form-label">Mother's Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="mother_name" class="form-control" id="u_mother_name" required placeholder="Mother's Name" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">E Mail</label>
                                                <div class="col-sm-9">
                                                    <input type="email" name="email" class="form-control" id="u_email" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="phone" class="form-control" id="u_phone" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="mobile" class="form-control" id="u_mobile" required value="" />
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="dob" class="form-control" id="u_dob" required value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="blood_group" class="col-sm-3 col-form-label">Blood Group</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="blood_group" class="form-control" id="u_blood_group" value="" />
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="last_education" class="col-sm-3 col-form-label">Highest Degree</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="last_education" class="form-control" id="u_last_education" value="" />
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="biography" class="col-sm-3 col-form-label">Short Biography</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="biography" class="form-control" id="u_biography" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="national_id" class="col-sm-3 col-form-label">National Id</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="national_id" class="form-control" id="u_national_id" value="" />
                                                </div>
                                            </div>

                                            <input type="hidden" name="action" class="form-control" value="personal" />

                                        </div>


                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="father_name">Father's Name</label>--}}
                                            {{--<input type="text" name="father_name" class="form-control" id="u_father_name" required placeholder="Father's Name" value="" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="mother_name">Mother's Name</label>--}}
                                            {{--<input type="text" name="mother_name" class="form-control" id="u_mother_name" required placeholder="Mother's Name" value="" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="email">Email</label>--}}
                                            {{--<input type="email" name="email" class="form-control" id="u_email" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="phone">Phone</label>--}}
                                            {{--<input type="text" name="phone" class="form-control" id="u_phone" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="middle_name">Mobile</label>--}}
                                            {{--<input type="text" name="mobile" class="form-control" id="u_mobile" required value="" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="dob">Date of Birth</label>--}}
                                            {{--<input type="text" name="dob" class="form-control" id="u_dob" required value="" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="blood_group">Blood Group</label>--}}
                                            {{--<input type="text" name="blood_group" class="form-control" id="u_blood_group" value="" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="last_education">Highest Degree</label>--}}
                                            {{--<input type="text" name="last_education" class="form-control" id="u_last_education" placeholder="Highest Degree" value="" />--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="biography">Short Biography</label>--}}
                                            {{--<textarea class="form-control" name="biography" cols="50" rows="4" id="u_biography" placeholder="Short Biography"></textarea>--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<label class="input-group" for="national_id">National Id</label>--}}
                                            {{--<input type="text" id="u_national_id", name="national_id" class="form-control" placeholder="National Id" value="" />--}}
                                        {{--</div>--}}

                                        <button type="submit" id="update_person_data" class="btnRegister btn-update_personal">Submit</button>


                                        {{--<input type="submit" class="btnRegister"  value="Register"/>--}}
                                    </div>

                                </div>

                                </form>
                            </div>


                            <div id="tab2">


                                <form class="form-horizontal" role="form" method="POST" action="">

                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td width="50%">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Employee ID</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="employee_id" class="form-control-plaintext" id="u_employee_id" value="5184616">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="50%">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Department</label>
                                                        <div class="col-sm-6">
                                                            {!! Form::select('department_id',$departments,null,array('id'=>'u_department_id','class'=>'form-control','autofocus')) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="50%">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Unit</label>
                                                        <div class="col-sm-6">
                                                            {!! Form::select('section_id',$sections,null,array('id'=>'u_section_id','class'=>'form-control')) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="50%">
                                                    <div class="form-group row">
                                                        <label for="staticEmail" class="col-sm-4 col-form-label">Designation</label>
                                                        <div class="col-sm-6">
                                                            {!! Form::select('designation_id',$designations,null,array('id'=>'u_designation_id','class'=>'form-control')) !!}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                        </tbody>

                                    </table>

                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Register</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="tab3">
                                <h2>Heading 3</h2>
                                <p>Atque ratione soluta laboriosam illo inventore amet ipsum aliquam assumenda harum provident nam accusantium neque debitis obcaecati maxime officia saepe ad ducimus in quam libero vero quasi. Saepe sit nisi?</p>
                            </div>

                            <div id="tab4">
                                <h2>Heading 4</h2>
                                <p>Quidem perferendis id sapiente cumque ullam repellendus dolorum odit rerum quibusdam tempora voluptatibus ipsum. Maiores laborum velit aperiam dicta quisquam assumenda at esse exercitationem culpa sequi porro minus ipsa aut.</p>
                            </div>

                            <div id="tab5">
                                <h2>Heading 5</h2>
                                <p>Iste eligendi ratione libero impedit quos necessitatibus labore corporis deserunt quo porro hic eius delectus ea ad amet dolore officiis debitis! Libero officia magnam consequuntur dignissimos molestias quia modi repellat.</p>
                            </div>

                            <div id="tab6">
                                <h2 style="text-align: center">Dependant</h2>

                                <form class="form-horizontal" id="n-dependant-form" role="form" method="POST" action="" accept-charset="UTF-8">

                                    {{ csrf_field() }}

                                    <input type="hidden" id="dependant_emp_id" name="dependant_emp_id" class="form-control" />


                                    <div class="container-fluid">

                                        <div class="form-group row">
                                            <label for="employee_name_id" class="col-sm-4 col-form-label">Employee Name & ID</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext" id="employee_name_id" value="">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="dependant_type" class="col-sm-2 col-form-label">Type</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('dependant_type',['F' => 'Father', 'M' => 'Mother','S'=>'Son', 'D'=>'Daughter','O'=>'Others'],null,array('id'=>'dependant_type','class'=>'form-control')) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="d_name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" id="name" class="form-control" required value="" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="d_dob" class="col-sm-2 col-form-label">Date of Birth</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="d_dob" id="d_dob" class="form-control" readonly />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="d_age" class="col-sm-2 col-form-label">Age</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="d_age" id="d_age" class="form-control" value="" />
                                            </div>
                                        </div>

                                        <input type="hidden" name="action" class="form-control" value="dependant" />


                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-success btn-dependant"><i class="fa fa-user-plus"></i>Submit</button>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>

                        </section>
                    </div>

                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    {{--<button type="submit" class="btn btn-primary">Save</button>--}}
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

    $('#employees-table').on("click", ".btn-employee-edit", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');
        // confirm then

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: {method: '_GET', submit: true},

                error: function (request, status, error) {
                    alert(request.responseText);
                },

                success: function (data) {

                    document.getElementById('update_emp_id').value = data.id;
                    document.getElementById('u_title_id').value = data.title_id;
                    document.getElementById('u_first_name').value=data.first_name;
                    document.getElementById('u_middle_name').value=data.middle_name;
                    document.getElementById('u_last_name').value=data.last_name;
                    document.getElementById('u_email').value=data.email;
                    document.getElementById('u_pr_address').value=data.pr_address;
                    document.getElementById('u_pm_address').value=data.pm_address;
                    document.getElementById('u_m_address').value=data.m_address;
                    document.getElementById('u_phone').value=data.phone;
                    document.getElementById('u_mobile').value=data.mobile;
                    document.getElementById('u_biography').value=data.biography;
                    document.getElementById('u_father_name').value=data.father_name;
                    document.getElementById('u_mother_name').value=data.mother_name;
                    document.getElementById('u_dob').value=data.dob;
                    document.getElementById('u_gender').value=data.gender;
                    document.getElementById('u_blood_group').value=data.blood_group 	;
                    document.getElementById('u_last_education').value=data.last_education;
                    document.getElementById('u_prof_speciality').value=data.prof_speciality;
                    document.getElementById('u_national_id').value=data.national_id;

                    //for dependant insert

                    document.getElementById('employee_name_id').value=data.full_name + ' : ' + data.professional.employee_id;
                    document.getElementById('dependant_emp_id').value = data.id;



                    $('#modal-update-employee').modal('show');

                },

            }).always(function (data) {
                $('#employees-table').DataTable().draw(false);
            });

    });


    $('#personal-form').on("submit", function (e) {
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

            error: function (request, status, error) {
                alert(request.responseText);
            },

            success: function (data) {

                $('#employees-table').DataTable().draw(false);
                $('#modal-update-employee').modal('hide');
            },

        }).always(function (data) {
            $('#employees-table').DataTable().draw(false);
        });

    });



    $('#n-dependant-form').on("submit", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        alert('here');
        return false;

        var url = 'dependant/update';
        // confirm then

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),

            error: function (request, status, error) {
                alert(request.responseText);
            },

            success: function (data) {

                $('#employees-table').DataTable().draw(false);
                // $('#modal-update-employee').modal('hide');
            },

        }).always(function (data) {
            $('#employees-table').DataTable().draw(false);
        });

    });



    $( function() {
        $( "#d_dob" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            inline:false
        });

        // $( "#joining_date" ).datetimepicker({
        //     format:'d-m-Y',
        //     timepicker: false,
        //     closeOnDateSelect: true,
        //     inline:false
        // });
        //
        // $( "#achievement_date" ).datetimepicker({
        //     format:'d-m-Y',
        //     timepicker: false,
        //     closeOnDateSelect: true,
        //     inline:false
        // });

    } );

</script>