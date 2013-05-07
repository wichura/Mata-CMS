<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataActiveRecord
 *
 * @author wichura
 */
class MataActiveRecord extends BaseActiveRecord {

    public function getLabel() {
        return $this->getPrimaryKey();
    }

}

?>
