<?php

/**
 * Description of CategorizedModelBehavior
 *
 * @author marcinwiatr
 */
class CategorizedModelBehavior extends CActiveRecordBehavior {

    private $_categories = array();

    public function afterSave($event) {
        $this->persistCategory();
        parent::afterSave($event);
    }

    /**
     * Returns categories for model
     * @return type array(Category)
     */
    public function getCategory($returnAsList = true) {

        $retVal = null;

        if ($this->getOwner()->Id != null) {
            $retVal = Category::model()->with(array(
                        "categoryitems" => array(
                            "condition" => "ItemId = " . $this->getOwner()->Id
                        )
                    ))->findAllByAttributes(array(
                "ModuleId" => $this->getOwner()->getModuleId()
                    ));

            if ($returnAsList) {
                $ids = array();
                foreach ($retVal as $c)
                    $ids[] = $c->Id;
                return $ids;
            }
        }

        return $retVal;
    }

    public function setCategory($values) {
        $this->_categories = $values;
    }

    public function persistCategory() {

        CategoryItem::model()->deleteAllByAttributes(array(
            "ItemId" => $this->getOwner()->Id,
            "ModuleId" => $this->getOwner()->getModuleId()
        ));

        if (!empty($this->_categories)) {
            foreach ($this->_categories as $id) {
               
                $r = new CategoryItem();
                $r->CategoryId = $id;
//                $r->CreatorCMSUserId = $this->getOwner()->CreatorCMSUserId;
//                $r->ModifierCMSUserId = $this->getOwner()->ModifierCMSUserId;
//                $r->ProjectKey = $this->getOwner()->ProjectKey;
                $r->ItemId = $this->getOwner()->Id;
                $r->ModuleId = $this->getOwner()->getModuleId();
                if ($r->save(false) == false) {
                    $error = current($r->errors);
                    echo $error;
                    exit;
                }
            }
        }
    }

}

?>

