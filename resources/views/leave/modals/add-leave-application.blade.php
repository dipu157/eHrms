<div class="modal fade right" id="modal-new-leave-app" tabindex="-1" role="dialog" aria-labelledby="modal-new-leave-app-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="add-leave-apply-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Leave Application for {!! $emp_info->full_name !!}
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


                                        <input id="emp_id" type="hidden" value="{!! $emp_info->id !!}" class="form-control" name="emp_id" required>

                                        <div class="form-group row">
                                            <label for="leave_id" class="col-sm-4 col-form-label text-md-right">Leave Type</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    {!! Form::select('leave_id',$leaves,null,array('id'=>'leave_id','class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row" id="duty_div">
                                            <label for="duty_date" class="col-sm-4 col-form-label text-md-right text-red">Duty Date</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="duty_date" id="duty_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group row">
                                            <label for="from_date" class="col-sm-4 col-form-label text-md-right">Start From</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="from_date" id="from_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="to_date" class="col-sm-4 col-form-label text-md-right">To Date</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="to_date" id="to_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="reason" class="col-sm-4 col-form-label text-md-right">Reason</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <textarea class="form-control" name="reason" cols="50" rows="4" id="reason">Backlog Data</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="location" class="col-sm-4 col-form-label text-md-right">Location & Mobile</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="location" id="location" class="form-control" autocomplete="off" value="Backlog Data">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="alternate" class="col-sm-4 col-form-label text-md-right">Alternate</label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="alternate" id="alternate" class="form-control typeahead-alter" autocomplete="off" value="Backlog Data">
                                                </div>
                                            </div>
                                        </div>

                                    <input id="alternate_id" type="hidden" class="form-control" name="alternate_id">


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

        $("#duty_div").hide();

        $('#leave_id').change(function(){

            $(this).val() == 3 ? $("#duty_div").show() : $("#duty_div").hide();
        });


        $( "#from_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });

        $( "#to_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });

        $( "#duty_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });

    } );

    $( function() {


        $('#add-leave-apply-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'leaveAddByAdmin/save';
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

                    $('#modal-new-leave-app').modal('hide');

                    var markup = "<tr><td>" + data.type.name + "</td><td>" + data.from_date + "</td>" +
                        "<td>" + data.to_date + "</td><td>" + data.reason + "</td><td>" + 'Approved' + "</td></tr>";

                    $('#application-table').append(markup);

                },

            });
        });

    } );


</script>