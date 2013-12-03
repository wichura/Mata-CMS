<?php

/**
 * Description of IcoCMSEditorialClient
 *
 * @author marcinwiatr
 */
class IcoCMSCategoryClient extends BaseIcoCMSClient {

    /**
     * Retrieves top level categories for a module
     * @param type $moduleId
     * @return type 
     */
    public function getParentCategories($moduleId = null) {

        $params = array("ParentId" => null);

        if ($moduleId !== null) {
            $params = array_merge($params, array(
                "ModuleId" => $moduleId
                    ));
        }

        return Category::model()->findAllByAttributes($params);
    }

    /**
     * Returns all categories for a given item
     * @param type $moduleId
     * @param type $itemId
     * @return type 
     */
    public function getCategoriesForItem($moduleId, $itemId) {
        return Category::model()->with(array(
                    "categoryitems" => array(
                        "condition" => "ItemId = " . $itemId
                    )
                ))->findAllByAttributes(array(
                    "ModuleId" => $moduleId
                ));
    }

    /**
     * Returns all items for a given category
     * @param type $categoryId
     * @param type used for casting
     * @return type 
     * 
     */
    public function getItemsForCategory($categoryId, $model = null, $orderContext = null) {
        if (is_numeric($categoryId) == false) {
            // assume by URI
            $cat = $this->getModel()->findByAttributes(array(
                "URI" => $categoryId
                    ));

            $categoryId = $cat->Id;
        }

        if ($orderContext == null) {
            $categoryItems = CategoryItem::model()->findAllByAttributes(array(
                "CategoryId" => $categoryId
                    ));
        } else {
            $categoryItems = CategoryItem::model()->order($orderContext)->findAllByAttributes(array(
                "CategoryId" => $categoryId
                    ));
        }

        if ($model != null) {
            $items = array();
            if ($model instanceof Product) {
                foreach ($categoryItems as $ci) {
                    array_push($items, Product::model()->findByPk($ci->ItemId));
                }
            } else if ($model instanceof Post) {
                foreach ($categoryItems as $ci) {
                    array_push($items, Post::model()->findByPk($ci->ItemId));
                }
            } else {
                throw new CHttpException(500, "Unknown model " . $model);
            }

            $categoryItems = $items;
        }

        return $categoryItems;
    }

    /**
     * Returns all categories for a module
     * @param type $moduleId
     * @return type 
     */
    public function getAllCategories($moduleId = null) {

        $params = array();

        if ($moduleId !== null) {
            $params = array_merge($params, array(
                "ModuleId" => $moduleId
                    ));
        }

        return Category::model()->findAllByAttributes($params);
    }

    /**
     * Returns all categories that are direct children of the parent category
     * @param type $parentCategoryId
     * @return type 
     */
    public function getChildCategories($parentCategoryId, $condition = array(), $params = "") {

        return $this->findAllByAttributes(array(
                    "ParentId" => $parentCategoryId
                ));
    }

    /**
     * Retrieves a category by URI
     * @param type $uri
     * @return type 
     */
    public function findByURI($uri) {
        return $this->findByAttributes(array(
                    "URI" => $uri
                ));
    }

    protected function getModel() {
        return Category::model();
    }

}

?>
