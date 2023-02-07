<div class="modal fade right" id="modal-new-notice" tabindex="-1" role="dialog" aria-labelledby="modal-new-notice-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="notice-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Notice
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


                                    {{--<div class="form-group row">--}}
                                        {{--<label for="title_id" class="col-sm-4 col-form-label text-md-right">Title</label>--}}
                                        {{--<div class="col-sm-8">--}}
                                            {{--<div class="input-group mb-3">--}}
                                                {{--{!! Form::select('title_id',$trainings,null,['id'=>'title_id','class'=>'form-control']) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                    <div class="form-group row required">
                                        <label for="notice_date" class="col-sm-4 col-form-label text-md-right">Notice Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="notice_date" id="notice_date" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="expiry_date" class="col-sm-4 col-form-label text-md-right">Expiry Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="expiry_date" id="expiry_date" value="" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row required">
                                        <label for="title" class="col-sm-4 col-form-label text-md-right">Title</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="title" id="title" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row required">
                                        <label for="sender" class="col-sm-4 col-form-label text-md-right">Sender Info</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="sender" id="sender" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="action" class="col-sm-4 col-form-label">Action</label>
                                        <div class="col-sm-8">

                                            <div class="form-group">
                                                <div class="maxl">
                                                    <label class="radio inline">
                                                        <input type="radio" id="action-y" name="action" value="{!! 'D' !!}" checked>
                                                        <span style="color: #0a0a0a">Display</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="action-n" name="action" value="{!! 'E' !!}">
                                                        <span style="color: #0a0a0a">Email</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="confidential" class="col-sm-4 col-form-label">Confidential</label>
                                        <div class="col-sm-8">

                                            <div class="form-group">
                                                <div class="maxl">
                                                    <label class="radio inline">
                                                        <input type="radio" id="confidential-y" name="confidential" value="{!! 'C' !!}">
                                                        <span style="color: #0a0a0a">Yes</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="confidential-n" name="confidential" value="{!! 'P' !!}" checked>
                                                        <span style="color: #0a0a0a">No</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="receiver" class="col-sm-4 col-form-label">Receiver</label>
                                        <div class="col-sm-8">

                                            <div class="form-group">
                                                <div class="maxl">
                                                    <label class="radio inline">
                                                        <input type="radio" id="receiver-a" name="receiver" value="{!! 'A' !!}" checked>
                                                        <span style="color: #0a0a0a">All</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="receiver-d" name="receiver" value="{!! 'D' !!}">
                                                        <span style="color: #0a0a0a">Department</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="receiver-p" name="receiver" value="{!! 'P' !!}">
                                                        <span style="color: #0a0a0a">Person</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="description" class="col-sm-4 col-form-label text-md-right">Details</label>
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


        $('#notice-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'newNoticeSave';
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

                    $('#notices-table').DataTable().draw(false);
                    $('#modal-new-notice').modal('hide');
                },

            }).always(function (data) {
                $('#notices-table').DataTable().draw(false);
            });
        });


        $( "#notice_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });


        $( "#expiry_date" ).datetimepicker({
            format:'d-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput : false,
            inline:false
        });



    } );


</script>