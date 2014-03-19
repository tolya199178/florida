<?php

/**
 * Controller interface for City management.
 */

/**
 * City Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 * 
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/city/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/city/edit/city_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /city/edit/city_id/99/ will invoke CityController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /city/edit/city_id/99/ will pass $_GET['city_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class CityController extends BackEndController
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
            
            // delegate to city model methods to determine ownership
            array(
                'allow',
                'expression' =>'CityAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("city_id"))',
                'actions'    =>array('edit'),
            ),
            
            // delegate to city model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );

        
    }


	/**
	 * Creates a new city record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the city details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a City record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the City validation (City::rules())
	 *  
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{
	    
		$cityModel = new City;
	    	    
	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($cityModel);
	    
	    if(isset($_POST['City']))
	    {

	        $cityModel->attributes=$_POST['City'];
	        
	        $uploadedFile = CUploadedFile::getInstance($cityModel,'image');
	        	         
	        if($cityModel->save())
	        {
	            
	            $imageFileName = 'city-'.$cityModel->city_id.'-'.$cityModel->image;
	            $imagePath = Yii::getPathOfAlias('webroot').'/uploads/images/city/'.$imageFileName;
	            	                 
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs($imagePath);
                }
                
	            $this->redirect(array('index'/* ,'id'=>$cityModel->city_id */));
	            	      
	        }  
	        
	            
	    }
	    
	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$cityModel,
	    ));

	}


	/**
	 * Updates an existing city record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested city's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing City record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the City validation (City::rules())
	 * 
	 * @param integer $city_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($city_id)
	{
	    
		$cityModel = City::model()->findByPk($city_id);
		if($cityModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');		    
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($cityModel);

		if(isset($_POST['City']))
		{
		    
		    // Make a note of the existing image. and delete it before overwriting.
		    $currentImagePath = Yii::getPathOfAlias('webroot').'/uploads/images/city/city-'.$cityModel->city_id.'-'.$cityModel->image;

		    $cityModel->attributes=$_POST['City'];
		    
			
	        $uploadedFile = CUploadedFile::getInstance($cityModel,'image');
	        	         
	        if($cityModel->save())
	        {
	            	            
	            $imageFileName = 'city-'.$cityModel->city_id.'-'.$cityModel->image;
	            $imagePath = Yii::getPathOfAlias('webroot').'/uploads/images/city/'.$imageFileName;
	            	                 
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs($imagePath);
                }
                
	            $this->redirect(array('index'/* ,'id'=>$cityModel->city_id */));
	            	      
	        } 
				
		}

		$this->render('details',array(
			'model'=>$cityModel,
		));
	}

	/**
	 * Deletes an existing city record.
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
        $cityId = $_POST['city_id'];
        $cityModel = City::model()->findByPk($cityId);
                
        if ($cityModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid city"}';
            Yii::app()->end();
        }
        

        $result = $cityModel->delete();
                	    
        if ($result == false) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }
        
        echo '{"result":"success", "message":""}';
         
	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by city
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all citys.
	    $this->redirect(array('list'));
	}
	

	/**
	 * Show all citys. Renders the city listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('City');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}
	
	/**
	 * Generates a JSON encoded list of all citys.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 * 
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or city bahaviour.
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
             $searchCriteria->addSearchCondition('t.city_name', $_POST['search']['value'], true, 'OR');
             $searchCriteria->addSearchCondition('t.city_alternate_name',  $_POST['search']['value'], true, 'OR');
                          
         }
        
        
        $city_list          = City::model()->findAll($searchCriteria);
        
        $rows_count 		= City::model()->count($searchCriteria);;
        $total_records 		= City::model()->count();
        
        
//         echo '{"iTotalRecords":'.$rows_count.',
//         		"iTotalDisplayRecords":'.$rows_count.',
//         		"aaData":[';
//         $f=0;
//         foreach($city_list as $r){
        
//             //print_r($r)
//             if($f++) echo ',';
//             echo   '[' .
//                 '"'  .$r->attributes['city_id'] .'"'
//               . ',"' .$r->attributes['city_name'] .'"'
//               . ',"' .$r->attributes['city_alternate_name'] .'"'
//             . ',""'
//             . ']';
//         }
//         echo ']}';
        	    
        
        $output = array(
            "iTotalRecords"         => $rows_count,
            "iTotalDisplayRecords"  => $total_records,
            "aaData"                => array()
        );
        
        foreach($city_list as $r){
        
            $row = array($r->attributes['city_id'],
                $r->attributes['city_name'],
                $r->attributes['city_alternate_name'],
                ''
            );
            $output['aaData'][] = $row;
        
        }
         
        echo json_encode($output);
	    
	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param City $cityModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($cityModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='city-form')
		{
			echo CActiveForm::validate($cityModel);
			Yii::app()->end();
		}
	}
}
