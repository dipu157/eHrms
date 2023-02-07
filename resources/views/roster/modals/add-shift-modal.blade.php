<div class="modal fade right" id="modal-new-shift" tabindex="-1" role="dialog" aria-labelledby="modal-new-shift-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="shift-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Shift
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
                                        <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="name" id="name" class="form-control" required autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="short_name" class="col-sm-4 col-form-label text-md-right">Short Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="short_name" id="short_name" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="session_id" class="col-sm-4 col-form-label text-md-right">Session</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::select('session_id',['M'=>'MORNING','E'=>'EVENING','N'=>'NIGHT'], null,['id'=>'session_id', 'class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="from_time" class="col-sm-4 col-form-label text-md-right">From Time</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="from_time" id="from_time" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="to_time" class="col-sm-4 col-form-label text-md-right">To Time</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="to_time" id="to_time" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="duty_hour" class="col-sm-4 col-form-label text-md-right">Duty Hour</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="duty_hour" id="duty_hour" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="end_next_day" class="col-sm-4 col-form-label text-md-right">End on Next Day</label>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <div class="maxl">
                                                    <label class="radio inline">
                                                        <input type="radio" id="end_next_day-y" name="end_next_day" value="{!! 1 !!}">
                                                        <span style="color: #0a0a0a">Yes</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="end_next_day-n" name="end_next_day" value="{!! 0 !!}" checked>
                                                        <span style="color: #0a0a0a">No</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="effective_from" class="col-sm-4 col-form-label text-md-right">Effective From</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="effective_from" id="effective_from" class="form-control" required readonly value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label text-md-right">Short Note</label>
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
        $( "#from_time" ).datetimepicker({
            format:'H:i',
            datepicker:false,
            closeOnTimeSelect:true,
            inline:false,
            step:30
        });

        $( "#to_time" ).datetimepicker({
            format:'H:i',
            datepicker: false,
            closeOnTimeSelect:true,
            inline:false,
            step:30,
            // onSelectTime: function () {
            //     document.getElementById('duty_hour').value = document.getElementById('from_time').value - document.getElementById('to_time').value;
            // }
        });

        $( "#effective_from" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect:true,
            inline:false,
        });


        $('#shift-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'shift/save';
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
                    $('#modal-new-shift').modal('hide');
                },

            }).always(function (data) {
                $('#shifts-table').DataTable().draw(false);
            });
        });


    } );

</script>