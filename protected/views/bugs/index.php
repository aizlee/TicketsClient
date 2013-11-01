<?php
/* @var $this BugsController */
/* @var $dataProvider CActiveDataProvider */


if (Yii::app()->controller->getAction()->getId()=='index'){ 
	$this->menu=array(
		array('label'=>'Create Bugs', 'url'=>array('create')),
	);
}
?>

	<h1>Bugs</h1>
<?php
	$this->widget('bootstrap.widgets.TbListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		 'ajaxUpdate'=>false,
		 'emptyText'=>'<i> Здесь рыбы нет!!!</i>',
	    'template'=>'{pager}{summary}{items}{pager}',
		'pager'=>array(
	        'maxButtonCount'=>'7',
	    ),
	
));?>
