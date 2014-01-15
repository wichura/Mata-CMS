<h1><?php echo UserModule::t("Users"); ?></h1>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="/user/registration">Create New User</a>
</div>
<p class='note'>Clicking items with <img class="keyboard-key-icon" src='<?php echo Yii::app()->mataAssetUrl ?>/images/<?php echo UserAgent::isMac() ? "mac-cmd-key-icon.png" : "pc-crtl-key-icon.png" ?>'  /> key reveals more options</p>
<?php
$this->widget('mata.widgets.MListView', array(
    'dataProvider' => $model->search(),
    "id" => "user-grid",
    'sortableAttributes' => $model->getSortableAttributes(),
    'itemView' => '_view',
));
?>