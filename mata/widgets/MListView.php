<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MListView
 *
 * @author wichura
 */
Yii::import("zii.widgets.CListView");

class MListView extends CListView {

    public $template = "{sorter}<div class='list-view standard-list'>{items}</div>{pager}";
    public $pager = array('class' => 'mata.widgets.pagers.InfinitePager');
    
    public function run() {
        $this->renderFilter();
        $this->renderListSelection();
        parent::run();
    }

    public function renderFilter() {

        $renderFilterId = 'filter-' . $this->id;
        Yii::app()->clientScript->registerScript('search', "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#$renderFilterId').keyup(function(){
        ajaxRequest = $(this).serialize();
        clearTimeout(ajaxUpdateTimeout);
        ajaxUpdateTimeout = setTimeout(function () {
            $.fn.yiiListView.update(
                '$this->id',
                {data: ajaxRequest,  url: '/user/admin'}
            )
        }, 300);
    });"
        );
        echo CHtml::textField("filter", (isset($_GET[$renderFilterId])) ? $_GET[$renderFilterId] : '', array('id' => $renderFilterId, "placeholder" => "Search"));
    }

    private function renderListSelection() {

        $listSelectionId = "list-selection-" . $this->id;

        echo <<<EOT
                <div id="$listSelectionId" class="list-selection">
    <h4>Selection</h4>
    <p class="label"></p>
    <div class="actions">
        <a onclick="$.fn.selection('delete')"  href="javascript:void(0)">
            <img src="/images/layout/icons/trash-icon.png" />
        </a>
        <a onclick="$.fn.selection('cancelSelection')" href="javascript:void(0)">
            <img src="/images/layout/icons/stop-icon2.png" />
        </a>
    </div>
</div>
EOT;
    }

}

?>
