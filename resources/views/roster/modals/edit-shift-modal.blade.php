<div class="modal fade right" id="modal-edit-shift" tabindex="-1" role="dialog" aria-labelledby="modal-edit-shift-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="shift-edit-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Shift Update
                    </p>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-body">

                                    <input type="hidden" name="id-for-update" id="id-for-update" class="form-control">

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="name" id="name-for-update" class="form-control" required autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="short_name" class="col-sm-4 col-form-label text-md-right">Short Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="short_name" id="short_name-for-update" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="from_time" class="col-sm-4 col-form-label text-md-right">From Time</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="from_time" id="from-time-for-update" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="to_time" class="col-sm-4 col-form-label text-md-right">To Time</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="to_time" id="to-time-for-update" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="duty_hour" class="col-sm-4 col-form-label text-md-right">Duty Hour</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="duty_hour" id="duty-hour-for-update" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="end_next_day" class="col-sm-4 col-form-label text-md-right">End on Next Day</label>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <div class="maxl">
                                                    <label class="radio inline">
                                                        <input type="radio" id="end_next_day-y-for-update" name="end_next_day" value="{!! 1 !!}">
                                                        <span style="color: #0a0a0a">Yes</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="end_next_day-n-for-update" name="end_next_day" value="{!! 0 !!}">
                                                        <span style="color: #0a0a0a">No</span>
                                                    </label>
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
        $( "#from-time-for-update" ).datetimepicker({
            format:'H:i',
            datepicker:false,
            closeOnTimeSelect:true,
            inline:false,
            step:30
        });

        $( "#to-time-for-update" ).datetimepicker({
            format:'H:i',
            datepicker: false,
            closeOnTimeSelect:true,
            inline:false,
            step:30
        });


        $('#shift-edit-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'shift/update';
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

                    $('#shifts-table').DataTable().draw(false);
                    $('#modal-edit-shift').modal('hide');
                },

            }).always(function (data) {
                $('#shifts-table').DataTable().draw(false);
            });
        });


    } );

</script>