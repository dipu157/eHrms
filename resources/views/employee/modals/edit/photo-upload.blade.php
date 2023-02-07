<div id="employee-photo-upload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employee-photo-upload-Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgba(0,207,229,0.2)">
                <h4 class="modal-title" id="employee-photo-upload-Label">Employee Image & Signature Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form class="form-horizontal" id="image-form" role="form" method="POST" action="{!! url('employee/image/save') !!}" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body">
                <div class="container-fluid">

                    <input type="hidden" id="phoro_emp_id" name="phoro_emp_id" class="form-control" />

                    <div class="imageupload panel panel-default">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left">Upload Employee Photo</h3>
                        </div>

                        <div class="file-tab panel-body">
                            <label class="btn btn-default btn-file">
                                <span>Browse</span>
                                <!-- The file is stored here. -->
                                <input type="file" name="photo-image" id="photo-image">
                            </label>
                            <button type="button" class="btn btn-default">Remove</button>
                        </div>
                    </div>

                    <div class="imageupload panel panel-default">
                        <div class="panel-heading clearfix">
                            <h3 class="panel-title pull-left">Upload Employee Signature</h3>
                        </div>

                        <div class="file-tab panel-body">
                            <label class="btn btn-default btn-file">
                                <span>Browse</span>
                                <!-- The file is stored here. -->
                                <input type="file" name="sign-image" id="sign-image">
                            </label>
                            <button type="button" class="btn btn-default">Remove</button>
                        </div>
                    </div>


                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect waves-light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light btn-photo-sign-save">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>

    $('#employees-table').on("click", ".btn-photo-sign", function (e) {
        e.preventDefault();

        document.getElementById('phoro_emp_id').value = $(this).data('rowid');

        $('#employee-photo-upload').modal('show');

    });



    // var $imageupload = $('.imageupload');
    // $imageupload.imageupload();

    $('.imageupload').imageupload({
        allowedFormats: [ "jpg", "jpeg", "png" ],
        previewWidth: 250,
        previewHeight: 250,
        maxFileSizeKb: 2048
    });


    // $('#imageupload-disable').on('click', function() {
    //     $imageupload.imageupload('disable');
    //     $(this).blur();
    // });
    //
    // $('#imageupload-enable').on('click', function() {
    //     $imageupload.imageupload('enable');
    //     $(this).blur();
    // });
    //
    // $('#imageupload-reset').on('click', function() {
    //     $imageupload.imageupload('reset');
    //     $(this).blur();
    // });


</script>