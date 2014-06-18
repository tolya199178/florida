<?php

/**
 * Controller interface for Mobile Carrier management.
 */

/**
 * Mobilecarrier Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/mobilecarrier/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/mobilecarrier/edit/mobile_carrier_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /mobilecarrier/edit/mobile_carrier_id/99/ will invoke MobilecarrierController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /mobilecarrier/edit/mobile_carrier_id/99/ will pass $_GET['mobile_carrier_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class MobilecarrierController extends BackEndController
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

            // delegate to mobile carrier model methods to determine ownership
            array(
                'allow',
                'expression' =>'MobileCarrier::model()->userHasDelegation(Yii::app()->request->getQuery("mobile_carrier_id"))',
                'actions'    =>array('edit'),
            ),

            // delegate to mobile carrier model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


	/**
	 * Creates a new mobile carrier record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the mobilecarrier details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a MobileCarrier record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the mobilecarrier validation (MobileCarrier::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{

		$mobilecarrierModel = new Mo;

	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($mobilecarrierModel);

	    if(isset($_POST['MobileCarrier']))
	    {

	        $mobilecarrierModel->attributes=$_POST['MobileCarrier'];

	        if($mobilecarrierModel->save())
	        {
	            $this->redirect(array('index'));
	        }

	    }

	    // Show the details screen
	    $this->render('details',array('model'=>$mobilecarrierModel));

	}


	/**
	 * Updates an existing mobile carrier record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested mobile carrier's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing MobileCarrier record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the  mobile carrier validation (MobileCarrier::rules())
	 *
	 * @param integer $mobile_carrier_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($mobile_carrier_id)
	{

		$mobilecarrierModel = MobileCarrier::model()->findByPk($mobile_carrier_id);

		if($mobilecarrierModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');
		}

		$this->performAjaxValidation($mobilecarrierModel);

		if(isset($_POST['MobileCarrier']))
		{

		    $mobilecarrierModel->attributes=$_POST['MobileCarrier'];

	        if($mobilecarrierModel->save())
	        {

	            $this->redirect(array('index'));

	        }

		}

		$this->render('details',array('model'=>$mobilecarrierModel));
	}

	/**
	 * Deletes an existing mobile carrier record.
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
        $mobilecarrierId = $_POST['mobile_carrier_id'];
        $mobilecarrierModel = MobileCarrier::model()->findByPk($mobilecarrierId);

        if ($mobilecarrierModel === null)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid mobile carrier"}';
            Yii::app()->end();
        }


        $result = $mobilecarrierModel->delete();

        if ($result === false)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }

        echo '{"result":"success", "message":""}';

	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by mobile carrier
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all mobile carriers.
	    $this->redirect(array('list'));
	}


	/**
	 * Show all mobile carriers. Renders the mobile carrier listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider = new CActiveDataProvider('MobileCarrier');
	    $this->render('list',array('dataProvider'=>$dataProvider));
	}

	/**
	 * Generates a JSON encoded list of all mobile carriers.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 *
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or mobile carrier bahaviour.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionListjson()
	{

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        // Paging criteria
        // Set defaults
        $limitStart 	            = isset($_POST['start'])?$_POST['start']:0;
        $limitItems 	            = isset($_POST['length'])?$_POST['length']:Yii::app()->params['PAGESIZEREC'];

        $searchCriteria->limit      = $limitItems;
        $searchCriteria->offset 	= $limitStart;


        // Only do livesearch if the keyword length < 2 characters
        if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
        {
            $searchCriteria->addSearchCondition('t.title', $_POST['search']['value'], true);
        }


        $listMobileCarrier          = MobileCarrier::model()->findAll($searchCriteria);

        $countRows 		            = MobileCarrier::model()->count($searchCriteria);;
        $countTotalRecords 		    = MobileCarrier::model()->count();

        /*
         * Output
         */
        $resultsMobileCarrierTable = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($listMobileCarrier as $itemMobileCarrier)
        {

            $rowResult = array(
                $itemMobileCarrier->attributes['mobile_carrier_id'],
                $itemMobileCarrier->attributes['mobile_carrier_name'],
                $itemMobileCarrier->attributes['can_send'],
                $itemMobileCarrier->attributes['recipient_address'],
                ''
            );

            $resultsMobileCarrierTable['aaData'][] = $rowResult;

        }

        echo CJSON::encode($resultsMobileCarrierTable);
        Yii::app()->end();

	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param MobileCarrier $mobilecarrierModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($mobilecarrierModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='$mobile-carrier-form')
		{
			echo CActiveForm::validate($mobilecarrierModel);
			Yii::app()->end();
		}
	}
}
