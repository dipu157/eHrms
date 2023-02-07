<div class="modal fade right" id="salary-set-modal" tabindex="-1" role="dialog" aria-labelledby="salary-set-modal-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info modal-lg" role="document">
        <!--Content-->
        <form action="{{ route('payroll/salary/save') }}"  method="post" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">Salary Setup</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-header">Salary Scale</div>
                                <div class="card-body">

                                    <div class="form-group row" id="md-name">
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="employee_id" id="employee_id" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row" id="md-name">
                                        <label for="basic" class="col-sm-4 col-form-label text-md-right">Basic</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="basic" id="basic" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="house_rent" class="col-sm-4 col-form-label text-md-right">House Rent</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="house_rent" id="house_rent" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="Medical" class="col-sm-4 col-form-label text-md-right">Medical</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="medical" id="medical" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="Entertainment" class="col-sm-4 col-form-label text-md-right">Entertainment</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="entertainment" id="entertainment" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="Conveyance" class="col-sm-4 col-form-label text-md-right">Conveyance</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="conveyance" id="conveyance" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="other_allowance" class="col-sm-4 col-form-label text-md-right">Other Allowance</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="other_allowance" id="other_allowance" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gross_salary" class="col-sm-4 col-form-label text-md-right">Gross Salary</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="gross_salary" id="gross_salary" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-header">Deductions</div>

                                <div class="card-body">

                                    <div class="form-group row" id="md-name">
                                        <label for="income_tax" class="col-sm-4 col-form-label text-md-right">Tax Amount</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="income_tax" id="income_tax" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row" id="md-name">
                                        <label for="advance" class="col-sm-4 col-form-label text-md-right">Advance</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="advance" id="advance" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="mobile_others" class="col-sm-4 col-form-label text-md-right">Mobile & Others</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="mobile_others" id="mobile_others" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="food" class="col-sm-4 col-form-label text-md-right">Food</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" value="0.00" name="food" id="food" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-header">Others</div>

                                <div class="card-body">

                                    <div class="form-group row" id="md-name">
                                        <label for="bank_id" class="col-sm-4 col-form-label text-md-right">Bank Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::select('bank_id',$banks,null,['id'=>'bank_id','class'=>'form-control']) !!}

                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row" id="md-name">
                                        <label for="account_no" class="col-sm-4 col-form-label text-md-right">Account No</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="account_no" id="account_no" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="tds_id" class="col-sm-4 col-form-label text-md-right">TDS Type</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                {!! Form::select('tds_id',['T'=>'TDS','C'=>'Cons TDS','N'=>'No TDS'],null,['id'=>'tds_id','class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="md-name">
                                        <label for="cash_salary" class="col-sm-4 col-form-label text-md-right">Cash Salary</label>
                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <input type="text" name="cash_salary" id="cash_salary" class="form-control" required>
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