<div class="list-view-item">
    <a href="/user/admin/update/id/<?php echo $data->id ?>">
        <div style="margin-right: 10px; width: 70px;" class="column">
            <?php echo Html::gravatar($data->email); ?>
        </div>
        <div style="width: 755px" class="column">
            <h4 class="model-label"><?php echo $data->getLabel() ?></h4>
            <hr />

            <ul class="horizontal">
                <li>Username: <?php echo $data->username ?></li>
                <li>Email: <?php echo $data->email ?></li>

                <?php if ($data->lastvisit_at): ?>
                    <li>Last visit: <?php echo Date::standardDateFormat($data->lastvisit_at) ?></li>
                <?php endif; ?>
            </ul>

        </div>
    </a>
    <div class='actions hidden'>
        <a class='delete' href='admin/delete/id/<?php echo $data->id ?>'>&nbsp;</a>
    </div>
</div>