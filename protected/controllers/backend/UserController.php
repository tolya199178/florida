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


	/**
	 * Creates a new user record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the user details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a User record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the User validation (User::rules())
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
	 * ...again with error messages from the User validation (User::rules())
	 * 
	 * @param integer $user_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($user_id)
	{
	    
		$userModel = User::model()->findByPk($user_id);
		if($userModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');		    
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
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
	    
	    // TODO: Only process ajax request
        $userId = $_POST['user_id'];
        $userModel = User::model()->findByPk($userId);
        
        // /////////////////////////////////////////////////////////////////
        // Disable deletion of superadmin user.
        // /////////////////////////////////////////////////////////////////
        if ($userModel->attributes['user_type'] == User::USER_TYPE_SUPERADMIN) {
            echo '{"result":"fail", "message":"Operation not supported"}';
            Yii::app()->end();         
        } 
        
        if ($userModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid user"}';
            Yii::app()->end();
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
            Yii::app()->end();
        }
        
        echo '{"result":"success", "message":""}';
         
	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by user
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
	    $this->redirect(array('list'));
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
        $searchCriteria = new CDbCriteria;
        
        // Paging criteria
        // Set defaults
        $limitStart 	           = isset($_POST['start'])?$_POST['start']:0;
        $limitItems 	           = isset($_POST['length'])?$_POST['length']:Yii::app()->params['PAGESIZEREC'];
        
        $searchCriteria->limit 		 = $limitItems;
        $searchCriteria->offset 	 = $limitStart;
                        
         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2)) {             
             $searchCriteria->addSearchCondition('t.first_name', $_POST['search']['value'], true, 'OR');
             $searchCriteria->addSearchCondition('t.last_name',  $_POST['search']['value'], true, 'OR');
                          
         }
        
        
        $user_list=User::model()->findAll($searchCriteria);
        
        $rows_count 		= User::model()->count($searchCriteria);;
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
              . ',"' .$r->attributes['user_type'] .'"'
              . ',"' .$r->attributes['user_name'] .'"'
              . ',"' .$r->attributes['first_name'] .' '. $r->attributes['last_name'] .'"'                
              . ',"' .$r->attributes['status'] .'"'
              . ',"' .$r->attributes['last_login'] .'"'
            . ',""'
            . ']';
        }
        echo ']}';
        	    
	    
	    
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
