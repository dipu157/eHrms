<div class="modal fade right" id="phone-update-modal" tabindex="-1" role="dialog" aria-labelledby="phone-update-modal-label" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="{{ route('phone/update') }}" method="post" id="phone-update-form" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Update phone
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
                                        <label for="user_name" class="col-sm-4 col-form-label text-md-right">Used By</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="used_by" id="used_by-for-update" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="department_id" class="col-sm-4 col-form-label text-md-right">Department</label>
                                        <div class="col-sm-8">
                                                {!! Form::select('department_id',$departments,$phoneNumbers[0]->department_id,['id'=>'department_id','class'=>'form-control','name'=>'department_id']) !!} 
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="floor_no" class="col-sm-4 col-form-label text-md-right">Floor No</label>
                                        <div class="col-sm-8">
                                            {!! Form::select('location_id',$locations,$phoneNumbers[0]->location_id,['id'=>'location_id','class'=>'form-control','name'=>'location_id']) !!}                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone_no" class="col-sm-4 col-form-label text-md-right">Phone No</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="phone_no" id="phone_no-for-update" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ip_address" class="col-sm-4 col-form-label text-md-right">IP Address</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="ip_address" id="ip_address-for-update" class="form-control" autocomplete="off">
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
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
                </div>

            </div>
            <!--/.Content-->
        </form>
    </div>
</div>
<!-- Modal: modalAbandonedCart-->

