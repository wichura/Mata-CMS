<h1>Update <?php echo $model->getLabel(); ?></h1>

<?php if (array_key_exists("versions", $model->behaviors())): ?>
    <div class='versions'>
        <a onclick='getVersions("<?php echo "/$modelNameLowerCase/$modelNameLowerCase/getVersions/id/$model->Id" ?>")' href='#'>Versions</a>
    </div>
<?php endif; ?>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<script>
        function getVersions(url) {
            mata.dialogBox.renderView("Previous Versions", url)
        }

</script>
