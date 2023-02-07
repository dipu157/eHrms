<div class="modal fade right" id="arear-setup-modal" tabindex="-1" role="dialog" aria-labelledby="advance-setup-modal-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="{{ route('payroll/arear/save') }}"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Arear Setup
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
                                        <label for="Arear Amount" class="col-sm-4 col-form-label text-md-right">Arear Amount</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="number" value="0.00" name="arear_amount" id="arear_amount" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="arear month" class="col-sm-4 col-form-label text-md-right">
                                        Arear Month</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                 <select class="form-control" name="arear_month" id="arear_month">
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="Deduction Status" class="col-sm-4 col-form-label text-md-right">Description</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                               <textarea class="form-control" rows="3" name="description" id="description"></textarea>
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