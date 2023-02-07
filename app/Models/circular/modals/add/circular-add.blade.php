<div class="modal fade right" id="modal-new-circular" tabindex="-1" role="dialog" aria-labelledby="modal-new-circular-label" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="{{ url('bioData/circular/save') }}" method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Circular</p>

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
                                        <label for="name" class="col-sm-4 col-form-label text-md-right">Circular Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="circular_name" id="circular_name" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="division_id" class="col-sm-4 col-form-label text-md-right">Department</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::select('department_id',$departments,null,array('id'=>'department_id','class'=>'form-control','autofocus')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="expire_date" class="col-sm-4 col-form-label text-md-right">Expire Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" name="expire_date" id="expire_date" class="form-control">
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