<?php
/* @var $this ContentBlockController */
/* @var $model ContentBlock */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'content-block-_form-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'Title'); ?>
        <?php echo $form->textField($model, 'Title'); ?>
        <?php echo $form->error($model, 'Title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Text'); ?>

        <?php
        
        $this->widget('mata.widgets.imperavi-redactor.ImperaviRedactorWidget', array(
            // you can either use it for model attribute
            'model' => $model,
            'attribute' => 'Text',
            'options' => array(
                "css" => ProjectSetting::model()->findAllValuesByKey(DbConfigurableHTML::constructSettingKey($model, "Text", "contentscss"))
            )
        ));
        ?>

        <?php echo $form->error($model, 'Text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Region'); ?>
        <?php echo $form->textField($model, 'Region'); ?>
        <?php echo $form->error($model, 'Region'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->