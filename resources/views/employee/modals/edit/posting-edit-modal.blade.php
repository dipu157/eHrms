<div class="modal fade right" id="posting-update-modal" tabindex="-1" role="dialog" aria-labelledby="posting-update-modal-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action=""  id="posting-update-form" method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Posting Update
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
                                        <label for="division_id" class="col-sm-4 col-form-label text-md-right">New Division</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('division_id',$divisions,null,array('id'=>'u_division_id','class'=>'form-control')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="department_id" class="col-sm-4 col-form-label text-md-right">New Department</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('department_id', $departments,null,array('id'=>'u_department_id','class'=>'form-control' ,'placeholder'=>'Please Select')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="section_id" class="col-sm-4 col-form-label text-md-right">New Section</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('section_id', $sections,null,array('id'=>'u_section_id','class'=>'form-control','placeholder'=>'Please Select')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="report_to" class="col-sm-4 col-form-label text-md-right">Report To</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="report" id="u_report_id" class="form-control typeahead" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="posting_start_date" class="col-sm-4 col-form-label text-md-right">Effective Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="posting_start_date" id="u_effective_date" class="form-control" readonly value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="posting_id" id="u_posting_id" class="form-control">
                                    <input type="hidden" name="report_to" id="u_report_to" class="form-control">
                                    <input type="hidden" name="emp_personals_id" id="u_emp_personals_id" class="form-control">

                                    <div class="form-group row">
                                        <label for="special" class="col-sm-4 col-form-label text-md-right">Special Duty</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="special" id="u_special" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="posting_notes" class="col-sm-4 col-form-label text-md-right">Posting Notes</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="posting_notes" cols="50" rows="4" id="u_posting_notes" placeholder="Posting Notes"></textarea>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="charge_type" class="col-sm-4 col-form-label text-md-right">Charge Status</label>
                                        <div class="col-sm-8">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="charge_type" id="u_inlineRadio1" value="I">
                                                <label class="form-check-label" for="inlineRadio1">In Charge</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="charge_type" id="u_inlineRadio2" value="S">
                                                <label class="form-check-label" for="inlineRadio2">2nd Man</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="charge_type" id="u_inlineRadio3" value="G">
                                                <label class="form-check-label" for="inlineRadio3">General</label>
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
        $( "#u_effective_date" ).datetimepicker({
            format:'Y-m-d',
            timepicker: false,
            closeOnDateSelect: true,
            inline:false
        });


        $('#posting-update-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'update';
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
                    alert('Posting Data Updated');

                    $('#posting-table').DataTable().draw(false);
                    $('#posting-update-modal').modal('hide');
                },

            }).always(function (data) {
                $('#posting-table').DataTable().draw(false);
            });
        });


    } );

</script>