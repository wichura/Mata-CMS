<div id="<?php echo $this->id ?>">

    <div class='multioption-container'>

        <?php
        foreach ($this->projects as $project):
            $selected = in_array($project->Id, $activeProjectIds);
            ?>
            <div class='multioption-element <?php if ($selected) echo "active" ?>' data-project-id="<?php echo $project->Id ?>">
                <a href='javascript:void(0)'><?php echo $project->Name ?></a>

                <?php echo Html::hiddenField("projectSelector[$project->Id]", $selected ? 1 : 0); ?>
            </div>

        <?php endforeach; ?>
    </div>
</div>