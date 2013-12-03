<?php

Yii::import("icoCMSClient.models.ItemURI");

class IcoCMSClientItemURIBehavior extends CActiveRecordBehavior {

    public function afterFind($event) {
        try {
            $itemURI = ItemURI::model()->findByAttributes(array(
                "ModuleId" => $this->getOwner()->getModuleId(),
                "Id" => $this->getOwner()->Id
                    ));

            if ($itemURI == null) {

                $cache = new ItemURI();
                $cache->attributes = array(
                    "ModuleId" => $this->getOwner()->getModuleId(),
                    "Id" => $this->getOwner()->Id,
                    "URI" => Yii::app()->getRequest()->getPathInfo()
                );

                $cache->save();
            } else if ($this->isCurrentPathMoreSpecific($itemURI->URI)) {
                $itemURI->URI = Yii::app()->getRequest()->getPathInfo();
                $itemURI->update();
            }
        } catch (Exception $e) {
            
        }
    }

    /**
     * Checks if the current path is more specific than the on in the db 
     * Used esp with blog posts, where url that is required is the one
     * leading to the full post
     * @param type $currentPath
     * @return type Bool
     */
    private function isCurrentPathMoreSpecific($currentPath) {
        return strlen(Yii::app()->getRequest()->getPathInfo()) > strlen($currentPath);
    }

}

?>
