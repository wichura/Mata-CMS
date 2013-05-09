<div class="list-view-item">
    <a href="project/update/id/<?php echo $data->getPrimaryKey() ?>">
        <div style="margin-right: 10px; width: 70px;" class="column">
            <?php echo Html::image($data->getAbsoluteFilePath()); ?>
        </div>
        <div style="width: 740px" class="column">
            <h4 class="model-label"><?php echo $data->getLabel() ?></h4>
            <hr />

            <ul class="horizontal">
                <?php
                foreach ($widget->sortableAttributes as $attribute) {

                    $value = $data->$attribute;

                    if (preg_match("/^\d\d\d\d-(\d)?\d-(\d)?\d \d\d:\d\d:\d\d$/", $value))
                        $value = Date::standardDateFormat($value);

                    if ($value != null)
                        echo CHtml::tag("li", array(), $data->getAttributeLabel($attribute) . ": " . $value);
                }
                ?>      
            </ul>

        </div>
    </a>
    <div class='actions hidden'>
        <a class='delete' href='project/delete/id/<?php echo $data->getPrimaryKey() ?>'>&nbsp;</a>
    </div>
</div>