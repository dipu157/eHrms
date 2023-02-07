<div class="modal fade right" id="advance-setup-modal" tabindex="-1" role="dialog" aria-labelledby="advance-setup-modal-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="{{ route('payroll/advance/save') }}"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Advance Setup
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
                                                <input type="hidden" name="employee_id" id="employee_id" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row" id="md-name">
                                        <label for="Advance Amount" class="col-sm-4 col-form-label text-md-right">Advance Amount</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="number" value="0.00" name="advance_amount" id="advance_amount" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="Installment Duration" class="col-sm-4 col-form-label text-md-right">Installment Duration</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="number" value="0.00" name="installment_duration" id="installment_duration" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="Per Month amount" class="col-sm-4 col-form-label text-md-right">Per Month amount</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="number" value="0.00" name="installment_amount_perMont" id="installment_amount_perMont" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="Deduction Status" class="col-sm-4 col-form-label text-md-right">Deduction Status</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="deduction_status" id="deduction_status">
                                                    <option value="1">Active</option>
                                                    <option value="2">In-Active</option>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="Recommended By" class="col-sm-4 col-form-label text-md-right">Recommended By</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="number" value="0.00" name="recommended_by" id="recommended_by" class="form-control">
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