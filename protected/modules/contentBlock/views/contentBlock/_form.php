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

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'Title'); ?>
        <?php echo $form->textField($model, 'Title'); ?>
        <?php echo $form->error($model, 'Title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Text'); ?>
        <?php echo $form->textArea($model, 'Text'); ?>
        <?php echo $form->error($model, 'Text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'Region'); ?>
        <?php echo $form->textField($model, 'Region'); ?>
        <?php echo $form->error($model, 'Region'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'Meta'); ?>
        <?php echo $form->textField($model, 'Meta'); ?>
        <?php echo $form->error($model, 'Meta'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->