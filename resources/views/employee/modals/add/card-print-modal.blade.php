<div class="modal fade right" id="modal-card-print" tabindex="-1" role="dialog" aria-labelledby="modal-card-print-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info" role="document">
        <!--Content-->
        <form action="{!! url('employee/cardprint') !!}" id="card-print-form"  method="get" accept-charset="utf-8">
            {{ csrf_field() }}

            <div class="modal-content">
                <!--Header-->
                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card text-primary bg-gray border-primary">

                                <div class="card-body">

                                    <div class="container-fluid">

                                        <input type="hidden" id="emp_id_card" name="emp_id_card" class="form-control" />

                                        <div class="form-group row">
                                            <label for="transport" class="col-sm-3 col-form-label">Side</label>
                                            <div class="col-sm-9">

                                                <div class="form-group">
                                                    <div class="maxl">
                                                        <label class="radio inline">
                                                            <input type="radio" id="front" name="action" value="front" checked>
                                                            <span style="color: #0a0a0a">Front</span>
                                                        </label>
                                                        <label class="radio inline">
                                                            <input type="radio" id="back" name="action" value="back">
                                                            <span style="color: #0a0a0a">Back</span>
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
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-card-print">Submit</button>
                </div>

            </div>
            <!--/.Content-->
        </form>
    </div>
</div>
<!-- Modal: modalAbandonedCart-->
<script>



</script>