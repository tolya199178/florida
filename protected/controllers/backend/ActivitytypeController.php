<?php

/**
 * Controller interface for Activitytype type management.
 */

/**
 * Activitytype Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/activitytype/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/activitytype/edit/activity_type_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /activitytype/edit/activity_type_id/99/ will invoke ActivitytypeController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /activitytype/edit/activity_type_id/99/ will pass $_GET['activity_type_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class ActivitytypeController extends BackEndController
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

            // delegate to activity type model methods to determine ownership
            array(
                'allow',
                'expression' =>'ActivityType::model()->userHasDelegation(Yii::app()->request->getQuery("activity_type_id"))',
                'actions'    =>array('edit'),
            ),

            // delegate to activity type model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


	/**
	 * Creates a new activity type record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the activity type details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Activitytype record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Activitytype validation (ActivityType::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{

		$activityModel = new ActivityType;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($activityModel);

	    if(isset($_POST['ActivityType']))
	    {

	        $activityModel->attributes=$_POST['ActivityType'];

	        if($activityModel->save())
	        {
	            $this->redirect(array('index'/* ,'id'=>$activityModel->activity_type_id */));

	        }

	    }

	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$activityModel,
	    ));

	}


	/**
	 * Updates an existing activity type record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested activitytype's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Activitytype record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Activitytype validation (ActivityType::rules())
	 *
	 * @param integer $activity_type_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($activity_type_id)
	{

		$activityModel = ActivityType::model()->findByPk($activity_type_id);
		if($activityModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($activityModel);

		if(isset($_POST['ActivityType']))
		{

		    $activityModel->attributes=$_POST['ActivityType'];

	        if($activityModel->save())
	        {

	            $this->redirect(array('index'/* ,'id'=>$activityModel->activity_type_id */));

	        }

		}

		$this->render('details',array(
			'model'=>$activityModel,
		));
	}

	/**
	 * Deletes an existing activity type record.
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
        $activityId = $_POST['activity_type_id'];
        $activityModel = ActivityType::model()->findByPk($activityId);

        if ($activityModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid activity type"}';
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
     * ....explicitly requested by activity type
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
	 * Show all activitys. Renders the activity type listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('ActivityType');
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
	 * ...determined by default settings or activity type bahaviour.
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


        $lstActivityType        = ActivityType::model()->findAll($searchCriteria);

        $countRows 		        = ActivityType::model()->count($searchCriteria);;
        $countTotalRecords 		= ActivityType::model()->count();

        /*
         * Output
        */
        $resultsActivityTypeTable = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($lstActivityType as $rowActivityType){

            $rowResult = array($rowActivityType->attributes['activity_type_id'],
                               $rowActivityType->activity['keyword'],
                               $rowActivityType->attributes['keyword'],
                               $rowActivityType->attributes['related_words'],
                               ''
                          );
            $resultsActivityTypeTable['aaData'][] = $rowResult;

        }

        echo CJSON::encode($resultsActivityTypeTable);

	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Activitytype $activityModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($activityModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='activity-type-form')
		{
			echo CActiveForm::validate($activityModel);
			Yii::app()->end();
		}
	}
}
