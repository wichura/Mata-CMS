<a href="/user/admin/update/id/<?php echo $data->id ?>" class="list-view-item">
    <div style="margin-right: 10px; width: 70px;" class="column">
        <?php echo Html::gravatar($data->email); ?>
    </div>
    <div style="width: 770px" class="column">
        <h4><?php echo $data->profile->FirstName ?> <?php echo $data->profile->LastName ?></h4>
        <hr />

        <ul class="horizontal">
            <li>Email: <?php echo $data->email ?></li>
            <li>Last visit: <?php echo Date::standardDateFormat($data->lastvisit_at) ?></li>
        </ul>
    </div>
</a>