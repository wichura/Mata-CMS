<?php

/**
 * Description of IcoCMSClientCategorizedModel
 *
 * @author marcinwiatr
 */
abstract class IcoCMSClientCategorizedModel extends BaseIcoCMSClientModel {

    public function getPrimaryCategory() {

        if (is_array($this->category) == false)
            $this->getRelated("category");

        if (empty($this->category) == false)
            return $this->category[0];

        return $this->category;
    }

    public function relations() {
        return array(
            'categoryitem' => array(self::HAS_MANY, 'CategoryItem', array('ItemId' => 'Id'), 'condition' => "category.ModuleId = " . $this->getModuleId()),
            'category' => array(self::HAS_MANY, 'Category', array('CategoryId' => 'Id'), 'through' => 'categoryitem')
        );
    }

    /**
     * Get ModuleId for the model 
     * return Number; 
     */
    protected abstract function getModuleId();
}

?>
