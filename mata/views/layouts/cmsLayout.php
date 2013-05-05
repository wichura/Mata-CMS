<?php $this->beginContent('mata.views.layouts.main'); ?>

<link rel="stylesheet" type="text/css" href="/css/cmsFormContent.css" />
<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

<div id="cms-form-content">
    <?php echo $content ?>
</div>

<?php $this->endContent(); ?>