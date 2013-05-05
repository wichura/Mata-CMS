<li class="list-view-item">
    <?php $user = User::model()->findByPk($data->UserId) ?>
    <div style="margin-right: 10px; width: 70px;" class="column">
        <?php echo Html::gravatar($user->email); ?>
    </div>
    <div style="width: 730px" class="column">
        <h4><?php echo $data->Event ?></h4>
        <hr />

    <ul class="horizontal">
        <li><?php echo Date::standardDateFormat($data->DateCreated) ?></li>
    </ul>
    </div>
    
</li>