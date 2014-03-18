<?php

/**
 * Controller interface for Activity management.
 */

/**
 * Activity Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 * 
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/activity/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/activity/edit/activity_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /activity/edit/activity_id/99/ will invoke ActivityController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /activity/edit/activity_id/99/ will pass $_GET['activity_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class ActivityController extends BackEndController
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
	 * Override CController access rules and provide base rules for derived class.
	 * All derived classes will automatically inherit the access rules provided.
	 *
	 * @param <none> <none>
	 *
	 * @return array list of accessrules to apply
	 * @access public
	 */
	/*
	 * TODO: Convert this to use RBAC
	 */
    public function accessRules()
    {
        
       // echo Yii::app()->user->isSuperAdmin();exit;

        return array(
            // Admin has full access. Applies to all controller action.
            array(
                'allow',
                'expression' =>'Yii::app()->user->isSuperAdmin()',
               // 'actions'    =>array('create'),
                
            ),
            
            // delegate to activity model methods to determine ownership
            array(
                'allow',
                'expression' =>'ActivityAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("activity_id"))',
                'actions'    =>array('edit'),
            ),
            
            // delegate to activity model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );

        
    }


	/**
	 * Creates a new activity record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the activity details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Activity record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Activity validation (Activity::rules())
	 *  
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{
	    
		$activityModel = new Activity;
	    	    
	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($activityModel);
	    
	    if(isset($_POST['Activity']))
	    {

	        $activityModel->attributes=$_POST['Activity'];
	        	         
	        if($activityModel->save())
	        {
	            $this->redirect(array('index'/* ,'id'=>$activityModel->activity_id */));
	            	      
	        }  	        
	            
	    }
	    
	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$activityModel,
	    ));

	}


	/**
	 * Updates an existing activity record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested activity's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Activity record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Activity validation (Activity::rules())
	 * 
	 * @param integer $activity_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($activity_id)
	{
	    
		$activityModel = Activity::model()->findByPk($activity_id);
		if($activityModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');		    
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($activityModel);

		if(isset($_POST['Activity']))
		{
		    
		    $activityModel->attributes=$_POST['Activity'];
	        	         
	        if($activityModel->save())
	        {
                
	            $this->redirect(array('index'/* ,'id'=>$activityModel->activity_id */));
	            	      
	        } 
				
		}

		$this->render('details',array(
			'model'=>$activityModel,
		));
	}

	/**
	 * Deletes an existing activity record.
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
        $activityId = $_POST['activity_id'];
        $activityModel = Activity::model()->findByPk($activityId);
                
        if ($activityModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid activity"}';
            Yii::app()->end();
        }
        

        $result = $activityModel->delete();
                	    
        if ($result == false) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        
        echo '{"result":"success", "message":""}';
         
	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by activity
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all activitys.
	    $this->redirect(array('list'));
	}
	

	/**
	 * Show all activitys. Renders the activity listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('Activity');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}
	
	/**
	 * Generates a JSON encoded list of all activitys.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 * 
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or activity bahaviour.
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
        
        $searchCriteria->limit 	   = $limitItems;
        $searchCriteria->offset    = $limitStart;
                        
         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2)) {             
             $searchCriteria->addSearchCondition('t.keyword', $_POST['search']['value'], true, 'OR');
             $searchCriteria->addSearchCondition('t.related_words',  $_POST['search']['value'], true, 'OR');
                          
         }
        
        
        $lstActivity      = Activity::model()->findAll($searchCriteria);
        
        $rows_count 		= Activity::model()->count($searchCriteria);;
        $total_records 		= Activity::model()->count();
        
        /*
         * Output
        */
        $output = array(
            "iTotalRecords"         => $rows_count,
            "iTotalDisplayRecords"  => $total_records,
            "aaData"                => array()
        );
        
        foreach($lstActivity as $rowActivity){
        
            $row = array($rowActivity->attributes['activity_id'],
                         $rowActivity->attributes['keyword'],
                         $rowActivity->attributes['related_words'],
                         ''
                        );
            $output['aaData'][] = $row;
        
        }

        echo CJSON::encode($output);
	    
	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Activity $activityModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($activityModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='activity-form')
		{
			echo CActiveForm::validate($activityModel);
			Yii::app()->end();
		}
	}
}
