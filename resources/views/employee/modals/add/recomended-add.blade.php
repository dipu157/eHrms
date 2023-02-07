<div class="modal fade right" id="modal-new-recomended" tabindex="-1" role="dialog" aria-labelledby="modal-new-recomended-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="recomended-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Add New Recomended
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-body">

                                        <input type="hidden" id="n_recomended_emp_id" name="n_recomended_emp_id" class="form-control" />

                                        <input type="hidden" name="employee_id" id="employee_id" class="form-control" value="{!! isset($data->professional->employee_id) ? $data->professional->employee_id : null !!}" />
                                        <input type="hidden" id="action" name="action" value="recomended-new" class="form-control" />

                                        <div class="container-fluid">

                                            <div class="form-group row">
                                                <label for="department" class="col-sm-4 col-form-label">Department</label>
                                                <div class="col-sm-8">
                                                    {!! Form::select('department_id',$departments, isset($data->professional->department_id) ? $data->professional->department_id : null,  array('id'=>'department_id','class'=>'form-control')) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="designation" class="col-sm-4 col-form-label">Designation</label>
                                                <div class="col-sm-8">
                                                   {!! Form::select('designation_id',$designations, isset($data->professional->designation_id) ? $data->professional->designation_id : null,  array('id'=>'designation_id','class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label for="promotion_name" class="col-sm-4 col-form-label">Promotion</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="promotion_name" id="promotion_name" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label for="change_designame" class="col-sm-4 col-form-label">Change Of Designation</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="change_designame" id="change_designame" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label for="aditional_amt" class="col-sm-4 col-form-label">Additional Amount</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="aditional_amt" id="aditional_amt" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="fixation_amt" class="col-sm-4 col-form-label">Fixation Amount</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="fixation_amt" id="fixation_amt" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="proposed_salary" class="col-sm-4 col-form-label">Proposed Salary</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="proposed_salary" id="proposed_salary" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label for="promoted" class="col-sm-4 col-form-label">Promoted</label>
                                         <div class="col-sm-8">
                                   

                                        {!! Form::select('promoted',['0'=>'No','1'=>'Yes'],null,['class'=>'form-control','id'=>'promoted']) !!}

                                         </div>
                                        </div>
                                            <div class="form-group row">
                                                <label for="effective_date" class="col-sm-4 col-form-label">Effective Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="effective_date" id="effective_date" class="form-control" readonly required />
                                                </div>
                                            </div>

                                            <div class="form-group row" id="md-name">
                                        <label for="descriptions" class="col-sm-4 col-form-label text-md-right">Description</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="descriptions" id="descriptions" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary btn-recomended-save">Save</button>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
                </div>

            </div>
            <!--/.Content-->
        </form>
    </div>
</div>
<!-- Modal: modalAbandonedCart-->

<script>

    $('#recomended-form').on("submit", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var url = 'save';
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

                $('#recomended-table').DataTable().draw(false);
                $('#modal-new-recomended').modal('hide');
            },

        }).always(function (data) {
            $('#recomended-table').DataTable().draw(false);
        });

    });

    $( function() {
        $( "#effective_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });

    } );

</script>