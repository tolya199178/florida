<?php

/**
 * Controller interface for User management.
 */

/**
 * User Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 * 
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/user/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/user/edit/user_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /user/edit/user_id/99/ will invoke UserController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /user/edit/user_id/99/ will pass $_GET['user_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class UserController extends BackEndController
{

    /**
     * Specify a list of filters to apply to action requests
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
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
	 * Creates a new user record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the user details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a User record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages form the User validation (User::rules())
	 *  
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{
	    
		$userModel=new User;
	    	    
	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($userModel);
	    
	    if(isset($_POST['User']))
	    {

	        $userModel->attributes=$_POST['User'];
	        if($userModel->save())
	            $this->redirect(array('index'/* ,'id'=>$userModel->user_id */));
	            
	    }
	    
	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$userModel,
	    ));

	}


	/**
	 * Updates an existing user record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested user's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing User record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages form the User validation (User::rules())
	 * 
	 * @param integer $user_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($user_id)
	{
	    
		$userModel=$this->loadModel($user_id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($userModel);

		if(isset($_POST['User']))
		{

		    // Unset the password if it is not supplied so that it is not
		    // ...overwritten by an empty password.
		    if (empty($_POST['User']['password']))
		        unset($_POST['User']['password']);

			$userModel->attributes=$_POST['User'];
			if($userModel->save())
				$this->redirect(array('index'/* ,'id'=>$userModel->user_id */));
				
		}

		$userModel->password = '';            // Don't show the password
		$this->render('details',array(
			'model'=>$userModel,
		));
	}

	/**
	 * Deletes an existing user record.
	 * ...As an additional safety measure, only POST requests are processed.
	 * ...Currently, instead of physically deleting the entry, the record is
	 * ...modified with the status fields set to 'deleted'
	 * ...We also expect a JSON request only, and return a JSON string providing
	 * ...outcome details. 
	 *
	 * @param <none> <none>
	 *
	 * @return string $result JSON encoded result and message
	 * @access public
	 */
	public function actionDelete()
	{
	    
	    // todo: add proper error message . iether flash or raiseerror. Might
	    // be difficult is sending ajax response.
	    
	    // todo: Only process ajax request
        $userId = $_POST['user_id'];
        $userModel = User::model()->findByPk($userId);
        
        if ($userModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid user"}';
        }
        
        // /////////////////////////////////////////////////////////////////
        // Instead of deleting the entry, the record is modified with the
        // ...status fields set to 'deleted'
        // /////////////////////////////////////////////////////////////////
        // $result = $user->delete();
        
        $userModel->status = 'deleted';
        
        $result = $userModel->save();
         
        	    
        if ($result == false) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
        }
        
        echo '{"result":"success", "message":""}';
         
	}


	/**
	 * Default action for the controller.
	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all users.
        $this->actionList();
	}
	

	/**
	 * Show all users. Renders the user listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('User');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}
	
	/**
	 * Generates a JSON encoded list of all users.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 * 
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or user bahaviour.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionListjson() {

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $criteria = new CDbCriteria;
        
        // Paging criteria
        // Set defaults
        $limitStart 	           = isset($_POST['iDisplayStart'])?$_POST['iDisplayStart']:0;
        $limitItems 	           = isset($_POST['iDisplayLength'])?$_POST['iDisplayLength']:Yii::app()->params['PAGESIZEREC'];
        
        $criteria->limit 		   = $limitItems;
        $criteria->offset 		   = $limitStart;
        
        // TODO: Search criteria
        
        
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
	 *
	 * @param integer $id the ID of the model to be loaded
	 *
	 * @return User the loaded model
	 * @throws CHttpException
	 * @access public
	 */
	public function loadModel($id)
	{
		$userModel=User::model()->findByPk($id);
		if($userModel===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $userModel;
	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param User $userModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($userModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($userModel);
			Yii::app()->end();
		}
	}
}
