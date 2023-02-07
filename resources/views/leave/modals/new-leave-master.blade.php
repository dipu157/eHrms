<div class="modal fade right" id="modal-new-leave-master" tabindex="-1" role="dialog" aria-labelledby="modal-new-leave-master-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="" id="leave-add-form"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Leave
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
                                        <label for="short_code" class="col-sm-4 col-form-label text-md-right">Short Code</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="short_code" id="short_code" class="form-control" required autocomplete="off" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="particulars" class="col-sm-4 col-form-label text-md-right">Particulars</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="particulars" cols="50" rows="4" id="particulars"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="yearly_limit" class="col-sm-4 col-form-label text-md-right">Yearly Limit</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="number" name="yearly_limit" id="yearly_limit" value="{!! 0 !!}" class="form-control" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="form-group row">--}}
                                        {{--<label for="show_roster" class="col-sm-4 col-form-label">Show in Roster</label>--}}
                                        {{--<div class="col-sm-8">--}}

                                            {{--<div class="form-group">--}}
                                                {{--<div class="maxl">--}}
                                                    {{--<label class="radio inline">--}}
                                                        {{--<input type="radio" id="show_roster-y" name="transport" value="Y" checked>--}}
                                                        {{--<span style="color: #0a0a0a">Yes</span>--}}
                                                    {{--</label>--}}
                                                    {{--<label class="radio inline">--}}
                                                        {{--<input type="radio" id="show_roster-n" name="transport" value="N">--}}
                                                        {{--<span style="color: #0a0a0a">No</span>--}}
                                                    {{--</label>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                    {{--</div>--}}


                                    <div class="form-group row">
                                        <label for="is_carry_forward" class="col-sm-4 col-form-label">Carry Forward</label>
                                        <div class="col-sm-8">

                                            <div class="form-group">
                                                <div class="maxl">
                                                    <label class="radio inline">
                                                        <input type="radio" id="is_carry_forward-y" name="is_carry_forward" value="Y">
                                                        <span style="color: #0a0a0a">Yes</span>
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" id="is_carry_forward-n" name="is_carry_forward" value="N" checked>
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


        $('#leave-add-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = 'leaveMaster/save';
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

                    $('#leaves-table').DataTable().draw(false);
                    $('#modal-new-leave-master').modal('hide');
                },

            }).always(function (data) {
                $('#leaves-table').DataTable().draw(false);
            });
        });

    } );


</script>