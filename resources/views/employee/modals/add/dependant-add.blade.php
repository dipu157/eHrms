<div class="modal fade right" id="modal-new-dependant" tabindex="-1" role="dialog" aria-labelledby="modal-new-dependant-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="dependant-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Designation
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>


                <input type="hidden" id="father" value="{!! $emp_data->father_name !!}" class="form-control" />
                <input type="hidden" id="mother" value="{!! $emp_data->mother_name !!}" class="form-control" />
                <input type="hidden" id="spouse" value="{!! $emp_data->spouse_name !!}" class="form-control" />

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-body">




                                        <input type="hidden" id="n_dependant_emp_id" name="n_dependant_emp_id" class="form-control" />
                                        <input type="hidden" id="action" name="action" value="dependant-new" class="form-control" />

                                        <div class="container-fluid">

                                            <div class="form-group row">
                                                <label for="dependant_type" class="col-sm-4 col-form-label">Type</label>
                                                <div class="col-sm-8">
                                                    {!! Form::select('dependant_type',['F' => 'Father', 'M' => 'Mother','P'=>'Spouse','S'=>'Son', 'D'=>'Daughter','O'=>'Others'],null,array('id'=>'dependant_type','class'=>'form-control')) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="d_name" class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="name" id="name" class="form-control" required value="{!! $emp_data->father_name !!}" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="d_dob" class="col-sm-4 col-form-label">Date of Birth</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="d_dob" id="d_dob" class="form-control" readonly />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="d_age" class="col-sm-4 col-form-label">Age</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="d_age" id="d_age" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="d_nid" class="col-sm-4 col-form-label">NID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="d_nid" id="d_nid" class="form-control" value="" />
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
                    <button type="submit" class="btn btn-primary btn-dependant-save">Save</button>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
                </div>

            </div>
            <!--/.Content-->
        </form>
    </div>
</div>
<!-- Modal: modalAbandonedCart-->

<script>

    $('#dependant-form').on("submit", function (e) {
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

                $('#dependants-table').DataTable().draw(false);
                $('#modal-new-dependant').modal('hide');
            },

        }).always(function (data) {
            $('#dependants-table').DataTable().draw(false);
        });

    });

    $( function() {
        $( "#d_dob" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });

    } );

</script>