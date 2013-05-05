<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseActiveRecord
 *
 * @author marcinwiatr
 */
class BaseActiveRecord extends CActiveRecord {

    public function beforeValidate() {

        $this->manageDates();
        $this->nullIfEmpty();

        return parent::beforeValidate();
    }

    private function nullIfEmpty() {
        foreach ($this->getTableSchema()->columns as $column) {
            if ($column->allowNull && trim($this->getAttribute($column->name)) === '')
                $this->setAttribute($column->name, null);
        }
    }

    private function manageDates() {
        if ($this->hasAttribute("DateModified"))
            $this->DateModified = new CDbExpression("NOW()");
    }

    public function getFirstError() {
        if ($this->hasErrors())
            return current(current($this->getErrors()));
    }

}

?>
