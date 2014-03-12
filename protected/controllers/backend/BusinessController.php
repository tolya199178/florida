<?php

/**
 * Controller interface for Business management.
 */

/**
 * Business Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 * 
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/business/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/business/edit/business_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /business/edit/business_id/99/ will invoke BusinessController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /business/edit/business_id/99/ will pass $_GET['business_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class BusinessController extends BackEndController
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
            
            // delegate to business model methods to determine ownership
            array(
                'allow',
                'expression' =>'BusinessAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("business_id"))',
                'actions'    =>array('edit'),
            ),
            
            // delegate to business model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );

        
    }


	/**
	 * Creates a new business record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the business details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Business record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Business validation (Business::rules())
	 *  
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{
	    
		$businessModel = new Business;
	    	    
	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($businessModel);
	    
	    if(isset($_POST['Business']))
	    {

	        $businessModel->attributes=$_POST['Business'];
	        
	        $uploadedFile = CUploadedFile::getInstance($businessModel,'image');
	        	         
	        if($businessModel->save())
	        {
	            
	            $imageFileName = 'business-'.$businessModel->business_id.'-'.$businessModel->image;
	            $imagePath = Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$imageFileName;
	            	                 
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs($imagePath);
                }
                
	            $this->redirect(array('index'/* ,'id'=>$businessModel->business_id */));
	            	      
	        }  
	        
	            
	    }
	    
	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$businessModel,
	    ));

	}


	/**
	 * Updates an existing business record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested business's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Business record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Business validation (Business::rules())
	 * 
	 * @param integer $business_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($business_id)
	{
	    
		$businessModel = Business::model()->findByPk($business_id);
		if($businessModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');		    
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($businessModel);

		if(isset($_POST['Business']))
		{
		    
		    // Make a note of the existing image. and delete it before overwriting.
		    $currentImagePath = Yii::getPathOfAlias('webroot').'/uploads/images/business/business-'.$businessModel->business_id.'-'.$businessModel->image;

		    $businessModel->attributes=$_POST['Business'];
		    
			
	        $uploadedFile = CUploadedFile::getInstance($businessModel,'image');
	        	         
	        if($businessModel->save())
	        {
	            	            
	            $imageFileName = 'business-'.$businessModel->business_id.'-'.$businessModel->image;
	            $imagePath = Yii::getPathOfAlias('webroot').'/uploads/images/business/'.$imageFileName;
	            	                 
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs($imagePath);
                }
                
	            $this->redirect(array('index'/* ,'id'=>$businessModel->business_id */));
	            	      
	        } 
				
		}

		$this->render('details',array(
			'model'=>$businessModel,
		));
	}

	/**
	 * Deletes an existing business record.
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
        $businessId = $_POST['business_id'];
        $businessModel = Business::model()->findByPk($businessId);
                
        if ($businessModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid business"}';
            Yii::app()->end();
        }
        

        $result = $businessModel->delete();
                	    
        if ($result == false) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        
        echo '{"result":"success", "message":""}';
         
	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by business
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all businesss.
	    $this->redirect(array('list'));
	}
	

	/**
	 * Show all businesss. Renders the business listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('Business');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}
	
	/**
	 * Generates a JSON encoded list of all businesss.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 * 
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or business bahaviour.
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
             $searchCriteria->addSearchCondition('t.business_name', $_POST['search']['value'], true);                          
         }
        
        
        $business_list          = Business::model()->findAll($searchCriteria);
        
        $rows_count 		= Business::model()->count($searchCriteria);;
        $total_records 		= Business::model()->count();
        
        
        
        /*
         * Output
         */
        $output = array(
            "iTotalRecords"         => $rows_count,
            "iTotalDisplayRecords"  => $total_records,
            "aaData"                => array()
        );
        
        foreach($business_list as $r){
            
            $row = array($r->attributes['business_id'],
                         $r->attributes['business_name'],
                         $r->attributes['business_name'],
                         $r->attributes['business_name'],
                         $r->attributes['business_email'],
                         $r->attributes['business_phone'],
                         $r->attributes['business_city_id'],
                         ''
                        );
            $output['aaData'][] = $row;

        }
        
         
        echo json_encode($output);
	    
	    
	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Business $businessModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($businessModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='business-form')
		{
			echo CActiveForm::validate($businessModel);
			Yii::app()->end();
		}
	}
}
