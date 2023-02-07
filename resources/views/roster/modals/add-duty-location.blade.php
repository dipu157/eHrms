<div class="modal fade right" id="modal-new-location" tabindex="-1" role="dialog" aria-labelledby="modal-new-location-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="location-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Location
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
                                        <label for="location" class="col-sm-4 col-form-label text-md-right">Location</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="location" id="location" class="form-control" required autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label text-md-right">Description</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="description" id="description" class="form-control" required autocomplete="off">
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


        $('#location-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'location/save';
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

                    $('#locations-table').DataTable().draw(false);
                    $('#modal-new-location').modal('hide');
                },

            }).always(function (data) {
                $('#locations-table').DataTable().draw(false);
            });
        });


    } );

</script>