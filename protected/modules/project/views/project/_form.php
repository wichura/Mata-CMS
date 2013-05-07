<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'project-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'Name'); ?>
        <?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'Name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'ProjectTypeId'); ?>
        <?php echo $form->textField($model,'ProjectTypeId',array('size'=>2,'maxlength'=>2)); ?>
        <?php echo $form->error($model,'ProjectTypeId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'URI'); ?>
        <?php echo $form->textField($model,'URI',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'URI'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'ClientId'); ?>
        <?php echo $form->textField($model,'ClientId',array('size'=>2,'maxlength'=>2)); ?>
        <?php echo $form->error($model,'ClientId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'Language'); ?>
        <?php echo $form->textField($model,'Language',array('size'=>15,'maxlength'=>15)); ?>
        <?php echo $form->error($model,'Language'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->