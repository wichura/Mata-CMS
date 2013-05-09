<style>
    #cms-form-content {
        height: 100%;
    }
</style>


<?php
$this->widget('mata.modules.media.extensions.yii-plupload.PluploadWidget', array(
    'config' => array(
        'runtimes' => 'html5',
        "dragdrop" => true,
        'url' => $this->createUrl('media/media/upload'),
        //'max_file_size' => str_replace("M", "mb", ini_get('upload_max_filesize')),
        'max_file_size' => Yii::app()->params['maxFileSize'],
        'chunk_size' => '1mb',
        'unique_names' => true,
//        'filters' => array(
//            array('title' => Yii::t('app', 'Images files'), 'extensions' => 'jpg,jpeg,gif,png'),
//        ),
        'language' => Yii::app()->language,
        'max_file_number' => 1,
        'autostart' => true,
        "drop_element" => "uploader",
        'jquery_ui' => false,
        'reset_after_upload' => true,
    ),
    'callbacks' => array(
        'FileUploaded' => 'function(up,file,response){console.log(response.response);}',
    ),
    'id' => 'uploader'
));
?>