<h1>Dashboard</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => Yii::app()->eventLog->getModel()->search(),
    "template" => "<div class='list-view standard-list'>{items}</div>",
    'itemView' => '_systemEventLogView',
));
?>