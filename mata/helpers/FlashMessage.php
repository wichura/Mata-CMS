<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FlashMessgae
 *
 * @author wichura
 */
class FlashMessage {

    public static function setStandardModelUpdateMessage($model) {
        Yii::app()->user->setFlash('success', $model->getLabel() . " has been updated");
    }
    
     public static function setStandardModelCreateMessage($model) {
        Yii::app()->user->setFlash('success',  "Created new " . get_class($model) . ": " . $model->getLabel());
    }

}

?>
