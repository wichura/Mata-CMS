<?php

/**
 * UWdropDownDep Widget
 *
 * @author Juan Fernando Gaviria <juan.gaviria@dsotogroup.com>
 * @link http://www.dsotogroup.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UWdropDownDep.php 123 2013-01-26 10:04:33Z juan.gaviria $
 */
class SexDropDown extends UWdropDownDep {

    public function viewAttribute($model, $field) {
    }

    /**
     * @param $model - profile model
     * @param $field - profile fields model item
     * @param $params - htmlOptions
     * @return string
     */
    public function editAttribute($model, $field, $htmlOptions = array()) {
        $list = array();

        if ($this->params['emptyField'])
            $list[0] = $this->params['emptyField'];

        $list["m"] = "Male";
        $list["f"] = "Female";

        return CHtml::activeDropDownList($model, $field->varname, $list, $htmlOptions = array(
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->controller->createUrl('/user/profileField/getDroDownDepValues'),
                        'data' => array('model' => $this->params['modelDestName'], 'field_dest' => $this->params['destField'], 'varname' => $field->varname, $field->varname => 'js:this.value', 'optionDestName' => $this->params['optionDestName']),
                        'success' => 'function(data){
        						$("#ajax_loader").hide();
        						$("#Profile_' . $this->params['destField'] . '").html(data)
        				}',
                        'beforeSend' => 'function(){
	        					$("#ajax_loader").fadeIn();
	        			}',
                    )
        ));
    }

}
