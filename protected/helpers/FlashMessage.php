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
        Yii::app()->user->setFlash('success', get_class($model) . " " . $model->getLabel() . " has been updated");
    }

}

?>
