<?php

/**
 * Controller interface for Email template management.
 */

/**
 * Mailtemplate Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 * 
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/mailtemplate/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/mailtemplate/edit/template_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /mailtemplate/edit/template_id/99/ will invoke MailtemplateController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /mailtemplate/edit/template_id/99/ will pass $_GET['template_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class MailtemplateController extends BackEndController
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
            
            // delegate to mailtemplate model methods to determine ownership
            array(
                'allow',
                'expression' =>'MailtemplateAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("template_id"))',
                'actions'    =>array('edit'),
            ),
            
            // delegate to mailtemplate model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );

        
    }


	/**
	 * Creates a new mailtemplate record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the mailtemplate details capture form
	 * ... - the (subsequent) POST request saves the submitted post data as a Mailtemplate record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Mailtemplate validation (Mailtemplate::rules())
	 *  
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{
	    
		$mailtemplateModel = new Mailtemplate;
	    	    
	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($mailtemplateModel);
	    
	    if(isset($_POST['Mailtemplate']))
	    {

	        $mailtemplateModel->attributes=$_POST['Mailtemplate'];
	        
	        $uploadedFile = CUploadedFile::getInstance($mailtemplateModel,'fldUploadImage');

	        if($mailtemplateModel->save())
	        {
	            $imageFileName = 'mailtemplate-'.$mailtemplateModel->template_id.'-'.$uploadedFile->name;
	            $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;
	            	                 
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs($imagePath);
                    $mailtemplateModel->image = $imageFileName;
                    
                    $this->createThumbnail($imageFileName);
                    
                    $mailtemplateModel->save();
                }
                
	            $this->redirect(array('index'));
	            	      
	        }
	        else {
                Yii::app()->user->setFlash('error', "Error creating a mailtemplate record.'");
	        }
	        
	            
	    }
	    
	    // Show the details screen
	    $this->render('details',array(
	        'model'=>$mailtemplateModel,
	    ));

	}


	/**
	 * Updates an existing mailtemplate record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested mailtemplate's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing Mailtemplate record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the Mailtemplate validation (Mailtemplate::rules())
	 * 
	 * @param integer $template_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($template_id)
	{
	    
		$mailtemplateModel = Mailtemplate::model()->findByPk($template_id);
		if($mailtemplateModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');		    
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($mailtemplateModel);

		if(isset($_POST['Mailtemplate']))
		{
            // Assign all fields from the form
		    $mailtemplateModel->attributes=$_POST['Mailtemplate'];
		    
		    $uploadedFile = CUploadedFile::getInstance($mailtemplateModel,'fldUploadImage');
		    
		    // Make a note of the existing image file name. It will be deleted soon.
		    $oldImageFileName = $mailtemplateModel->image;
		    
		    if(!empty($uploadedFile))  // check if uploaded file is set or not
		    {
		        // Save the image file name
		        $mailtemplateModel->image = 'mailtemplate-'.$mailtemplateModel->template_id.'-'.$uploadedFile->name;
		    }
		    
		    if($mailtemplateModel->save())
		    {
		         
		        if(!empty($uploadedFile))  // check if uploaded file is set or not
		        {
		            
		            $imageFileName = 'mailtemplate-'.$mailtemplateModel->template_id.'-'.$uploadedFile->name;
		            $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;
		            
		            // Remove existing images
		            if (!empty($oldImageFileName))
		            {
		                $this->deleteImages($oldImageFileName);		                
		            }

		            // Save the new uploaded image
		            $uploadedFile->saveAs($imagePath);
		    
		            $this->createThumbnail($imageFileName);
		        }
		    
		        $this->redirect(array('index'));
		    
		    }
		    else {
		        Yii::app()->user->setFlash('error', "Error creating a mailtemplate record.'");
		    }
				
		}

		$this->render('details',array(
			'model'=>$mailtemplateModel,
		));
	}


	/**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by mailtemplate
   	 * Does not perform any processing. Redirects to the desired action instead.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionIndex()
	{
	    // Default action is to show all mailtemplates.
	    $this->redirect(array('list'));
	}
	

	/**
	 * Show all mailtemplates. Renders the mailtemplate listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('Mailtemplate');
	    $this->render('list',array(
	        'dataProvider'=>$dataProvider,
	    ));
	}
	
	/**
	 * Generates a JSON encoded list of all mailtemplates.
	 * The output is customised for the datatables Jquery plugin.
	 * http://www.datatables.net
	 * 
	 * The table plugins send a request for a JSON list based on criteria
	 * ...determined by default settings or mailtemplate bahaviour.
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
                        
         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
         {             
             $searchCriteria->addSearchCondition('t.mailtemplate_name', $_POST['search']['value'], true);                          
         }
        
        
        $mailtemplate_list      = Mailtemplate::model()->findAll($searchCriteria);
        
        $rows_count 		= Mailtemplate::model()->count($searchCriteria);;
        $total_records 		= Mailtemplate::model()->count();
       
        /*
         * Output
         */
        $output = array(
            "iTotalRecords"         => $rows_count,
            "iTotalDisplayRecords"  => $total_records,
            "aaData"                => array()
        );
        
        foreach($mailtemplate_list as $r){
            
            $row = array($r->attributes['template_id'],
                         $r->attributes['mailtemplate_name'],
                         $r->attributes['mailtemplate_name'],
                         $r->attributes['mailtemplate_name'],
                         $r->attributes['mailtemplate_email'],
                         $r->attributes['mailtemplate_phone'],
                         $r->attributes['mailtemplate_city_id'],
                         ''
                        );
            $output['aaData'][] = $row;

        }
        
         
        echo json_encode($output);
	    
	    
	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param Mailtemplate $mailtemplateModel the model to be validated
	 *
	 * @return string validation results message
	 * @access protected
	 */
	protected function performAjaxValidation($mailtemplateModel)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mailtemplate-form')
		{
			echo CActiveForm::validate($mailtemplateModel);
			Yii::app()->end();
		}
	}
	
	/**
	 * Delete images for the mailtemplate. Normally invoked when mailtemplate is being deleted.
	 *
	 * @param string $imageFileName the name of the file
	 *
	 * @return <none> <none>
	 * @access public
	 */
	private function deleteImages($imageFileName)
	{
        $imagePath = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        @unlink($imagePath);
        
        $thumbnailPath     = $this->thumbnailsDirPath.DIRECTORY_SEPARATOR.$imageFileName;
        @unlink($thumbnailPath);
	}
	
	/**
	 * Create a thumbnail image from the filename give, Store it in the thumnails folder.
	 *
	 * @param <none> <none>
	 * 
	 * @return <none> <none>
	 * @access public
	 */
	private function createThumbnail($imageFileName, $sizeWidth = 0, $sizeHeight = 0)
	{
	    
	    if ($sizeWidth == 0)
	    {
	        $sizeWidth     = $this->thumbnailWidth;
	    }
	    if ($sizeHeight == 0)
	    {
	        $sizeHeight    = $this->thumbnailHeight;
	    }
	    
	    $thumbnailPath     = $this->thumbnailsDirPath.DIRECTORY_SEPARATOR.$imageFileName;
	    $imagePath         = $this->imagesDirPath.DIRECTORY_SEPARATOR.$imageFileName;
	    
	    $imgThumbnail              = new Thumbnail;
	    $imgThumbnail->PathImgOld  = $imagePath;
	    $imgThumbnail->PathImgNew  = $thumbnailPath;
	    
	    $imgThumbnail->NewWidth    = $sizeWidth;
	    $imgThumbnail->NewHeight   = $sizeHeight;
	    
	    $result = $imgThumbnail->create_thumbnail_images();
	    
	    if (!$result)
	    {
	        return false;
	    }
	    else
	    {
	        return true;
	    }

	}
	
}
