<?php
/* @var $this BugsController */
/* @var $model Bugs */


$this->menu=array(
	array('label'=>'List Bugs', 'url'=>array('index')),
	array('label'=>'Create Bugs', 'url'=>array('create')),
);
?>



<?php
	//var_dump($dataProvider);
	$this->widget('bootstrap.widgets.TbListView', array(
		'dataProvider'=>$model,
		'itemView'=>'_view',
));?>

<?php if(count($comments) > 0):?>
    <ul class="comments-list">
        <?php foreach($comments as $comment):?>
            <li id="comment-<?php echo $comment['comment_id']; ?>">
                <div class="comment-header">
                    <?php echo $comment['user_name'];?>
                    <?php echo Yii::app()->dateFormatter->formatDateTime($comment['create_time']);?>
                </div>
                <div>
                    <?php echo CHtml::encode($comment['comment_text']);?>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t('Небыло ни единого комментария!');?></p>
<?php endif; ?>


<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	        'action'=>Yii::app()->urlManager->createUrl('bugs/addComment'. '&id='.$id),
	)); ?>
	 <?php echo CHtml::textArea('Text','',
		 array('id'=>'idTextField', 
			       'cols' => 60, 
	 		       'rows' => 10,
	 		       'maxlength'=>100)); ?>

	 <?php $this->widget('bootstrap.widgets.TbButton', array(
	 	 'buttonType'=>'submitLink',
	     'label'=>'Добавить комментарий',
	    'type'=>'primary',
	    'url'=>array('owner_id'=>$id),
	 )); ?>

<?php $this->endWidget(); ?>	 
 </div>