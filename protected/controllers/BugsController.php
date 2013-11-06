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
				'actions'=>array('create','update', 'createBug', 'addComment','fileUpload', 'imageUpload', 'imageList'),
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
		$client=new SoapClient('http://localhost/buglist/index.php?r=stock/quote', array('exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => true));
			
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'comments'=>$client->loadComment($id),
			'id'=>$id,
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

	public function actionAddComment()
	{
		$client = new SoapClient('http://localhost/buglist/index.php?r=stock/quote', array('exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => true));
		$commentData['comment_text'] =$_POST['Text'];
		$commentData['user_name'] = Yii::app()->user->username;
		$commentData['user_email'] = Yii::app()->user->email;
		$commentData['create_time'] = date("U");
		$commentData['owner_id'] = $_GET['id'];
		$commentData['owner_name'] = 'Tickets';
		$client->addComment($commentData);
		 $this->redirect(array('view','id'=>$_GET['id']));
		// 	'model'=>$this->loadModel($_GET['owner_id']),
		// 	'comments'=>$client->loadComment($_GET['owner_id']),
		// 	'id'=>$_GET['owner_id'],
		//));
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
		$client=new SoapClient('http://localhost/buglist/index.php?r=stock/quote', array('exceptions' => true, 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => true));
		$user_id =  Yii::app()->user->id;

		$query=$client->loadTicket($id);
		$model=new CArrayDataProvider($query, array(
	        'id'=>'id',
	        'keyField' => 'id',
	    ));
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

	public function actions()
    {
        return array(
            'fileUpload'=>array(
                'class'=>'ext.imperaviRedactorWidget.actions.FileUpload',
                'uploadCreate'=>true,
            ),
            'imageUpload'=>array(
                'class'=>'ext.imperaviRedactorWidget.actions.ImageUpload',
                'uploadCreate'=>true,
                 'permissions'=>0777,
            ),
            'imageList'=>array(
                'class'=>'ext.imperaviRedactorWidget.actions.ImageList',
            ),
        );
    }
}
