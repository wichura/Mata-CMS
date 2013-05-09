<style>
    #cms-form-content {
        height: 100%;
    }
    .span5 {
        width: 470px;;
    }
    .progress {
        height: 20px;
        margin-bottom: 20px;
        overflow: hidden;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .ui-progressbar-value {
        background-color: #62c462;
        height: 100%;
    }
    
    .list-view .column img {
        width: 70px;
    }
</style>

<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <!-- The global progress information -->
        <div class="span5 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="bar" style="width:0%;"></div>
            </div>
            <!-- The extended global progress information -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The loading indicator is shown during file processing -->
    <div class="fileupload-loading"></div>
    <br>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
</form>

<?php
$this->widget('mata.modules.media.widgets.FileUploader', array(
));
?>

<?php
$this->widget('mata.widgets.MListView', array(
    'id' => "media-grid",
    'dataProvider' => $model->search(),
    'itemView' => $this->getViewFile("_view") ? "_view" : "mata.views.module._view",
    'sortableAttributes' => $model->getSortableAttributes()
));
?>
