<?php
/* @var $this BugsController */
/* @var $model Bugs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bugs-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_employee'); ?>
		<?php echo $form->textField($model,'id_employee'); ?>
		<?php echo $form->error($model,'id_employee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_client'); ?>
		<?php echo $form->textField($model,'id_client'); ?>
		<?php echo $form->error($model,'id_client'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_creator'); ?>
		<?php echo $form->textField($model,'id_creator'); ?>
		<?php echo $form->error($model,'id_creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receive_date'); ?>
		<?php echo $form->textField($model,'receive_date'); ?>
		<?php echo $form->error($model,'receive_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>
		<?php echo $form->textField($model,'post',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'complete_date'); ?>
		<?php echo $form->textField($model,'complete_date'); ?>
		<?php echo $form->error($model,'complete_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->