<?php

class UserController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/column2';

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

// 	/**
// 	 * Specifies the access control rules.
// 	 * This method is used by the 'accessControl' filter.
// 	 * @return array access control rules
// 	 */
// 	public function accessRules()
// 	{
// 		return array(
// 			array('allow',  // allow all users to perform 'index' and 'view' actions
// 				'actions'=>array('index','view'),
// 				'users'=>array('*'),
// 			),
// 			array('allow', // allow authenticated user to perform 'create' and 'update' actions
// 				'actions'=>array('create','update'),
// 				'users'=>array('@'),
// 			),
// 			array('allow', // allow admin user to perform 'admin' and 'delete' actions
// 				'actions'=>array('admin','delete'),
// 				'users'=>array('admin'),
// 			),
// 			array('deny',  // deny all users
// 				'users'=>array('*'),
// 			),
// 		);
// 	}

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
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('list',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionListjson() {
// 	    $user_list = User::model()->findAll();
// 	    CJSON::encode($user_list);
//
// 	    $model = Post::model()->find();
// 	    CJSON::encode($model);

        //print_r($_POST);
        
        $limit_start 	= isset($_POST['iDisplayStart'])?$_POST['iDisplayStart']:0;
        $limit_items 	= isset($_POST['iDisplayLength'])?$_POST['iDisplayLength']:10;
        
        
        // $chief_director_id = Yii::app()->request->getQuery('chief_director_id');
        
        $criteria = new CDbCriteria;
        
        $criteria->limit 			= $limit_items;
        $criteria->offset 			= $limit_start;
        
        
        // 		if ($chief_director_id != null) {
        // 			$criteria->condition = " chief_director_id = '$chief_director_id' ";
        // 		}
        
        $user_list=User::model()->findAll($criteria);
        
        $rows_count 		= User::model()->count($criteria);;
        $total_records 		= User::model()->count();
        
        
        echo '{"iTotalRecords":'.$rows_count.',
        		"iTotalDisplayRecords":'.$rows_count.',
        		"aaData":[';
        $f=0;
        foreach($user_list as $r){
        
            //print_r($r)
            if($f++) echo ',';
            echo   '[' .
                '"'  .$r->attributes['user_id'] .'"'
                    . ',"' .$r->attributes['user_name'] .'"'
                        . ',"' .$r->attributes['first_name'] .' '. $r->attributes['last_name'] .'"'
                            . ',"' .$r->attributes['user_type'] .'"'
                            . ',""'
                                
                                . ']';
        }
        echo ']}';
        	    
	    
	    
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
