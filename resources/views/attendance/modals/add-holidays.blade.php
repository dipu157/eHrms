<div class="modal fade right" id="modal-new-holiday" tabindex="-1" role="dialog" aria-labelledby="modal-new-holiday-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="holiday-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New holiday
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
                                        <label for="title" class="col-sm-4 col-form-label text-md-right">Title</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="title" id="title" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="from_date" class="col-sm-4 col-form-label text-md-right">From Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="from_date" id="from_date" class="form-control" required readonly autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="to_date" class="col-sm-4 col-form-label text-md-right">To Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="to_date" id="to_date" class="form-control" required readonly autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label text-md-right">Description</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="description" cols="50" rows="4" id="description"></textarea>
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
        $( "#from_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect:true,
            scrollInput : false,
            inline:false,
        });

        $( "#to_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect:true,
            scrollInput : false,
            inline:false,
            // onSelectTime: function () {
            //     document.getElementById('duty_hour').value = document.getElementById('from_time').value - document.getElementById('to_time').value;
            // }
        });

        $('#holiday-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'publicHoliday/save';
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

                    $('#holidays-table').DataTable().draw(false);
                    $('#modal-new-holiday').modal('hide');
                },

            }).always(function (data) {
                $('#holidays-table').DataTable().draw(false);
            });
        });


    } );

</script>