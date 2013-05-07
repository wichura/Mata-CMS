<h1>Projects</h1>

<?php $this->widget('mata.widgets.MListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>