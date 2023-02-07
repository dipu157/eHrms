<div class="modal fade right" id="modal-new-history" tabindex="-1" role="dialog" aria-labelledby="modal-new-history-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="history-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Add New History
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

                                        <input type="hidden" id="n_history_emp_id" name="n_history_emp_id" class="form-control" />

                                        <input type="hidden" name="employee_id" id="employee_id" class="form-control" value="{!! isset($data->professional->employee_id) ? $data->professional->employee_id : null !!}" />
                                        <input type="hidden" id="action" name="action" value="history-new" class="form-control" />

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
                                                <label for="basic" class="col-sm-4 col-form-label">Basic</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="basic" id="basic" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="gross_salary" class="col-sm-4 col-form-label">Gross Salary</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="gross_salary" id="gross_salary" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="effective_date" class="col-sm-4 col-form-label">Effective Date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="effective_date" id="effective_date" class="form-control" readonly />
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
                    <button type="submit" class="btn btn-primary btn-history-save">Save</button>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
                </div>

            </div>
            <!--/.Content-->
        </form>
    </div>
</div>
<!-- Modal: modalAbandonedCart-->

<script>

    $('#history-form').on("submit", function (e) {
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

                $('#historys-table').DataTable().draw(false);
                $('#modal-new-history').modal('hide');
            },

        }).always(function (data) {
            $('#historys-table').DataTable().draw(false);
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