<h1><?php echo $modelName ?>s</h1>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="<?php echo $modelNameLowerCase ?>/create">Create New <?php echo $modelName ?></a>
</div>
<p class='note'>Clicking items with <img src='/images/layout/icons/mac-cmd-key-icon.png' height='16px' /> key reveals more options</p>

<?php
$this->widget('mata.widgets.MListView', array(
    'id' => "$modelNameLowerCase-grid",
    'dataProvider' => $model->search(),
    'itemView' => $this->getViewFile("_view") ? "_view" : "mata.views.module._view",
    'sortableAttributes' => $model->getSortableAttributes()
));
?>
