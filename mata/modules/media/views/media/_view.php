<div class="list-view-item">
    <a href="project/update/id/<?php echo $data->getPrimaryKey() ?>">
        <div style="width: 835px" class="column">
            <h4 class="model-label"><?php echo $data->getLabel() ?></h4>
            <hr />

            <ul class="horizontal">
                <?php
                echo CHtml::tag("li", array(), $data->getAttributeLabel('DateCreated') . ": " . Date::standardDateFormat($data->DateCreated));
                ?>

                <?php
                if ($data->URI)
                    echo CHtml::tag("li", array(), CHtml::encode($data->getAttributeLabel('URI')) . ": " . CHtml::encode($data->URI));
                ?>
            </ul>

        </div>
    </a>
    <div class='actions hidden'>
        <a class='delete' href='project/delete/id/<?php echo $data->getPrimaryKey() ?>'>&nbsp;</a>
    </div>
</div>