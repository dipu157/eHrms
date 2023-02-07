<div class="modal fade right" id="modal-new-training-schedule" tabindex="-1" role="dialog" aria-labelledby="modal-new-training-schedule-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="training-schedule-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Training Schedule
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
                                        <label for="title_id" class="col-sm-4 col-form-label text-md-right">Title</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::select('title_id',$trainings,null,['id'=>'title_id','class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="trainer" class="col-sm-4 col-form-label text-md-right">Trainer</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="trainer" id="trainer" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="start_from" class="col-sm-4 col-form-label text-md-right">Start From</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="start_from" id="start_from" value="{!! \Carbon\Carbon::now()->format('d-m-Y H:i:s') !!}" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="end_on" class="col-sm-4 col-form-label text-md-right">Ends On</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="end_on" id="end_on" value="{!! \Carbon\Carbon::now()->format('d-m-Y H:i:s') !!}" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="form-group row">--}}
                                        {{--<label for="participants" class="col-sm-4 col-form-label text-md-right">Participants</label>--}}
                                        {{--<div class="col-sm-8">--}}
                                            {{--<div class="input-group mb-3">--}}
                                                {{--<input type="number" name="participants" id="participants" value="{!! 0 !!}" class="form-control" required autocomplete="off">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


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


        $('#training-schedule-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'scheduleSave';
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

                    $('#schedules-table').DataTable().draw(false);
                    $('#modal-new-training-schedule').modal('hide');
                },

            }).always(function (data) {
                $('#schedules-table').DataTable().draw(false);
            });
        });


        $( "#start_from" ).datetimepicker({
            format:'d-m-Y H:i',
            inline:false,
            step:30,
        });

        $( "#end_on" ).datetimepicker({
            format:'d-m-Y H:i',
            inline:false,
            step:30,
        });


    } );


</script>