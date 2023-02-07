<div id="document-upload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="document-upload-Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgba(0,207,229,0.2)">
                <h4 class="modal-title" id="document-upload-Label">Upload Document</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form class="form-horizontal" id="file-upload-form" role="form" method="POST" action="{!! url('document/saveDocumentFile') !!}" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-body">
                    <div class="container-fluid">

                        <input type="hidden" id="id-for-upload" name="id-for-upload" class="form-control" />

                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <h3 class="panel-title pull-left">Upload PDF File</h3>
                            </div>

                            <div class="file-tab panel-body">
                                <label class="btn btn-default btn-file">
                                    {{--<span>Browse</span>--}}
                                    <!-- The file is stored here. -->
                                    <input type="file" name="doc-file" id="doc-file" class="form-control-file">
                                </label>
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



</script>