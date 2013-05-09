<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileUploader
 *
 * @author wichura
 */
class FileUploader extends CWidget {

    public function init() {


        $this->registerClientScript();
    }

    private function registerClientScript() {

        $baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('mata.modules.media.widgets.assets') . '/fileUploader', false, -1, YII_DEBUG);

        $cs = Yii::app()->getClientScript();


        echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>';
        echo '<script src="http://blueimp.github.com/jQuery-Image-Gallery/js/jquery.image-gallery.min.js"></script>';
        
        $cs->registerScriptFile($baseScriptUrl . '/js/jquery.fileupload.js', CClientScript::POS_END);
          $cs->registerScriptFile($baseScriptUrl . '/js/jquery.fileupload-jui.js', CClientScript::POS_END);
        $cs->registerScriptFile($baseScriptUrl . '/js/main.js', CClientScript::POS_END);
         $cs->registerCssFile($baseScriptUrl . '/css/jquery.fileupload-ui.css', CClientScript::POS_END);
        $cs->registerCssFile($baseScriptUrl . '/css/style.css', CClientScript::POS_END);
       
        
        
    }

}

?>
