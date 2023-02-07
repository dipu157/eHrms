<div class="modal fade right" id="modal-new-posting" tabindex="-1" role="dialog" aria-labelledby="modal-new-posting-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="posting-form" method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Education
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

                                    <input type="hidden" id="n_posting_emp_id" name="n_posting_emp_id" class="form-control" />


                                    <div class="form-group row">
                                        <label for="division_id" class="col-sm-4 col-form-label text-md-right">New Division</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('division_id',$divisions,null,array('id'=>'division_id','class'=>'form-control')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="department_id" class="col-sm-4 col-form-label text-md-right">New Department</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('department_id', $departments,null,array('id'=>'department_id','class'=>'form-control' ,'placeholder'=>'Please Select')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="section_id" class="col-sm-4 col-form-label text-md-right">New Section</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('section_id', $sections,null,array('id'=>'section_id','class'=>'form-control','placeholder'=>'Please Select')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="report_to" class="col-sm-4 col-form-label text-md-right">Report To</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="report_to" id="report_to" class="form-control typeahead" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="effective_date" class="col-sm-4 col-form-label text-md-right">Effective Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="date" name="effective_date" id="effective_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="to_id" id="to_id" class="form-control">

                                    <div class="form-group row">
                                        <label for="special" class="col-sm-4 col-form-label text-md-right">Special Duty</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="special" id="special" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="posting_notes" class="col-sm-4 col-form-label text-md-right">Posting Notes</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="posting_notes" cols="50" rows="4" id="posting_notes" placeholder="Posting Notes"></textarea>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="charge_type" class="col-sm-4 col-form-label text-md-right">Charge Status</label>
                                        <div class="col-sm-8">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="charge_type" id="inlineRadio1" value="I">
                                                <label class="form-check-label" for="inlineRadio1">In Charge</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="charge_type" id="inlineRadio2" value="S">
                                                <label class="form-check-label" for="inlineRadio2">2nd Man</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="charge_type" id="inlineRadio3" value="G" checked>
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

    $(document).on('click', '.form-control.typeahead', function() {

        $(this).typeahead({
            minLength: 1,
            displayText:function (data) {
                return data.full_name + ' : ' + data.professional.employee_id;
            },

            source: function (query, process) {
                $.ajax({
                    url: "{{ url('autocomplete/employees') }}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: 'query=' + query ,
                    success: function(data) {
                        return process(data);
                    }
                });
            },
            afterSelect: function (data) {
                $('#to_id').val(data.id);
                $('#u_report_to').val(data.id);

            }

        });
    });



    //

    $( function() {
        // $( "#effective_date" ).datetimepicker({
        //     format:'d-m-Y',
        //     timepicker: false,
        //     closeOnDateSelect: true,
        //     inline:false
        // });


        $('#posting-form').on("submit", function (e) {
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
                    alert('Posting Data Added');

                    $('#posting-table').DataTable().draw(false);
                    $('#modal-new-posting').modal('hide');
                },

            }).always(function (data) {
                $('#posting-table').DataTable().draw(false);
            });
        });


    } );

</script>