<div class="modal fade right" id="modal-new-documentation" tabindex="-1" role="dialog" aria-labelledby="modal-new-documentation-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="documentation-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New document
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


                                    <div class="form-group row">
                                        <label for="document_type" class="col-sm-4 col-form-label text-md-right">Document Type</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                            {!! Form::select('document_type_id',$document_type,null,array('id'=>'document_type_id','class'=>'form-control','placeholder' => 'Select Document Type')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row required">
                                        <label for="document_date" class="col-sm-4 col-form-label text-md-right">Document Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="document_date" id="document_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="uhid" class="col-sm-4 col-form-label text-md-right">UHID</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="uhid" id="uhid" class="form-control"  autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="employee_id" class="col-sm-4 col-form-label text-md-right">Employee ID</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="employee_id" id="employee_id" class="form-control"  autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                            {!! Form::select('department_id', $departments,null,array('id'=>'department_id','class'=>'form-control' ,'placeholder'=>'Please Select')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="item/procedure_name" class="col-sm-4 col-form-label text-md-right">Item/Procedure Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="item/procedure_name" id="item/procedure_name" class="form-control"  autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="doctor_name" class="col-sm-4 col-form-label text-md-right">Doctor Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="doctor_name" id="doctor_name" class="form-control"  autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="doctor_department_name" class="col-sm-4 col-form-label text-md-right">Doctor's Department</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="doctor_department_name" id="doctor_department_name" class="form-control"  autocomplete="off" autofocus>
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
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
                </div>

            </div>
            <!--/.Content-->
        </form>
    </div>
</div>
<!-- Modal: modalAbandonedCart-->
<script>
    $( function() {

        $('#documentation-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           // alert("Document Submit clicled");

            var url = 'documentationSave';
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

                    $('#documents-table').DataTable().draw(false);
                    $('#modal-new-documentation').modal('hide');
                },

            }).always(function (data) {
                $('#documents-table').DataTable().draw(false);
            });
        });

        $( "#document_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });

    } );


</script>