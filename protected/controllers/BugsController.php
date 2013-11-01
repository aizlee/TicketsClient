<?php

class BugsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'createBug'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Bugs;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bugs']))
		{
			//$model->attributes=$_POST['Bugs'];
			$temp = $_POST['Bugs'];
			$temp['id_client'] = Yii::app()->user->id;
			$temp['receive_date'] = date("Y-m-d");
			$client=new SoapClient('http://localhost/buglist/index.php?r=stock/quote', array('exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => true));
			$client->addBug($temp);
		 	$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bugs']))
		{
			$model->attributes=$_POST['Bugs'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$client=new SoapClient('http://localhost/buglist/index.php?r=stock/quote', array('exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => true));
		$id =  Yii::app()->user->id;
		$query=$client->loadModel($id);	
		$dataProvider=new CArrayDataProvider($query, array(
	        'id'=>'id',
	        'pagination'=>array(
	            'pageSize'=>10,
	        ),
	    ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bugs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bugs']))
			$model->attributes=$_GET['Bugs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bugs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bugs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bugs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bugs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
