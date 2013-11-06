<?php
/* @var $this BugsController */
/* @var $data Bugs */
?>

<div class="view">
<div class="wrapper">
	<div class="info">
		<div class="item">
			<label>№:</label>	
			<p><?php echo CHtml::link(CHtml::encode($data['id']), array('view', 'id'=>$data['id'])); ?></p>
		</div>

		<div class="item imageStatus">
		<?php
		$currentDate =  new DateTime(date("Y-m-d")); 
		switch($data['status']): // Switch image for status
		 	
		 	case '0': ?>
			<i class= "fa fa-bug fa-2x"></i>
			<?php break;?>

			<?php case '1': ?>
			<i class="fa fa-cog fa-2x fa-spin"></i>
			<?php break;?>

			<?php case '2': ?>
			<i class="fa fa-envelope fa-2x"></i>
			<?php break;?>

			<?php case '3': ?>
			<i class="fa fa-exclamation-circle fa-2x"></i>
			<?php break;?>

			<?php case '4': ?>
			<i class="fa fa-archive fa-2x"></i>
			<?php endswitch; ?>
	</div>		
		
	</div>

	<div class = date-block>
		<div class="item">
			<i class="fa fa-sign-in" title="Дата поступления"></i> 
			<p><?php echo CHtml::encode(Yii::app()->dateFormatter->format("dd-MM-yyyy", $data['receive_date'])); ?></p>
		</div>

		<div class="item">
			<i class="fa fa-thumb-tack" title="Дата принятия"></i>
			<p><?php echo CHtml::encode(Yii::app()->dateFormatter->format("dd-MM-yyyy", $data['start_date'])); ?></p>
		</div>
		
		<div class="item">
			<i class="fa fa-flag" title="Дата завершения"></i>
			<p><?php echo CHtml::encode(Yii::app()->dateFormatter->format("dd-MM-yyyy", $data['complete_date'])); ?></p>
		</div>
	</div>
</div>
	
	<div class="item post">
		<label>Описание:</label>
		<div class="post-details"> <?php echo $data['post']; ?> </div>
	</div>

	<div class="wrapper man">
		<div class="item">
			<i class="fa fa-tasks" title="Отправитель"></i>
			<p><?php echo CHtml::encode($data['id_creator']);?></p>
		</div>
		<?php if (!empty($data['id_client'])):?>
			<div class="item">
				<i class="fa fa-male" title="Клиент"></i>
				<p><?php echo CHtml::encode($data['id_client']);?></p>
			</div>
		<?php endif ?>
		<div class="item">
			<i class="fa fa-user" title="Сотрудник"></i>
			<p><?php echo CHtml::encode($data['id_employee']);?></p>
		</div>
	</div>

	<div class="action">
		<div class="item status">
			<label>Статус:</label>
			<p><?php echo CHtml::encode(Bugs::getStatus($data['status'])); ?></p>
		</div>
	</div>
</div>