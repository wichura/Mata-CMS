<h1>Projects</h1>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="project/create">Create New Project</a>
</div>
<p class='note'>Clicking items with <img src='/images/layout/icons/mac-cmd-key-icon.png' height='16px' /> key reveals more options</p>
<?php
$this->widget('mata.widgets.MListView', array(
    'id' => 'project-grid',
    'dataProvider' => $model->search(),
    'itemView' => "_view",
    'sortableAttributes' => array("Name", "DateCreated"),
));
?>
