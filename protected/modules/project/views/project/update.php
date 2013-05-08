<h1>Update <?php echo $model->getLabel(); ?></h1>
<div class='versions'>
    <a onclick='getVersions("/project/project/getVersions/id/<?php echo $model->Id ?>")' href='#'>Versions</a>
</div>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<script>


        function getVersions(url) {
            mata.dialogBox.renderView("Previous Versions", url)
        }

</script>
