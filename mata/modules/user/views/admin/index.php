<h1><?php echo UserModule::t("Users"); ?></h1>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="/user/registration">Create New User</a>
</div>
<p class='note'>Clicking items with <img src='/images/layout/icons/mac-cmd-key-icon.png' height='16px' /> key reveals more options</p>
<?php
$this->widget('mata.widgets.MListView', array(
    'dataProvider' => $model->search(),
    "id" => "user-grid",
    'sortableAttributes' => $model->getSortableAttributes(),
    'itemView' => '_view',
));
?>