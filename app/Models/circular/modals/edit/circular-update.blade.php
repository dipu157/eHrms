<div class="modal fade right" id="circular-update-modal" tabindex="-1" role="dialog" aria-labelledby="circular-update-modal-label" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="{{ url('bioData/circular/update') }}" method="post" id="circular-update-form" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Update Circular
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


                                    <div class="form-group row" id="md-name">
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="id" id="id-for-update" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="circular_name" class="col-sm-4 col-form-label text-md-right">Circular Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="circular_name" id="circular_name-for-update" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="department_id" class="col-sm-4 col-form-label text-md-right">Department</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::select('department_id',$departments,$circular[0]->department_id,['id'=>'department_id','class'=>'form-control']) !!} 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="expire_date" class="col-sm-4 col-form-label text-md-right">Expired Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" name="expire_date" id="expire_date-for-update" class="form-control">
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
    $('#circular-update-form').on("submit", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[circular_name="csrf-token"]').attr('content')
            }
        });


        var url = 'circular/update';
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

                $('#circular-table').DataTable().draw(false);
                $('#circular-update-modal').modal('hide');
            },

        }).always(function(data) {
            $('#circular-table').DataTable().draw(false);
        });

    });
</script>