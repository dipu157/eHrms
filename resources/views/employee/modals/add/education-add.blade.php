<div class="modal fade right" id="modal-new-education" tabindex="-1" role="dialog" aria-labelledby="modal-new-education-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="education-form" method="post" accept-charset="utf-8">
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

                                    <input type="hidden" id="n_education_emp_id" name="n_education_emp_id" class="form-control" />


                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label text-md-right">Degree Type</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">

                                                {!! Form::select('degree_type',['A' => 'Academic', 'P' => 'Professional','O'=>'Others'],null,array('id'=>'degree_type','class'=>'form-control')) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="name" id="name" class="form-control" required autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="institution" class="col-sm-4 col-form-label text-md-right">Institution</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="institution" id="institution" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="passing_year" class="col-sm-4 col-form-label text-md-right">Passing Year</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::selectYear('passing_year', 1950, 2022,2010,array('id'=>'passing_year','class'=>'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="result" class="col-sm-4 col-form-label text-md-right">Result</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="result" id="result" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="achievement_date" class="col-sm-4 col-form-label text-md-right">Achivement Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="date" name="achievement_date" id="achievement_date" class="form-control">
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





        $('#education-form').on("submit", function (e) {
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

                    $('#educations-table').DataTable().draw(false);
                    $('#modal-new-education').modal('hide');
                },

            }).always(function (data) {
                $('#educations-table').DataTable().draw(false);
            });
        });


    } );

</script>