<?php

/**
 * Controller interface for Email template management.
 */

/**
 * MailTemplate Controller class to provide access to controller actions for clients.
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
 * ...eg. /mailtemplate/edit/template_id/99/ will invoke MailTemplateController::actionEdit()
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
class MailTemplateController extends BackEndController
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
                'expression' =>'MailTemplateAdmin::model()->userHasDelegation(Yii::app()->request->getQuery("template_id"))',
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
	 * ... - the (subsequent) POST request saves the submitted post data as a MailTemplate record.
	 * ...If the save (POST request) is successful, the default method (index()) is called.  
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the MailTemplate validation (MailTemplate::rules())
	 *  
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCreate()
	{
	    
		$mailtemplateModel = new MailTemplate;
	    	    
	    // Uncomment the following line if AJAX validation is needed
	    // todo: broken for Jquery precedence order loading
	    // $this->performAjaxValidation($mailtemplateModel);
	    
	    if(isset($_POST['MailTemplate']))
	    {

	        $mailtemplateModel->attributes=$_POST['MailTemplate'];
	        
	        if($mailtemplateModel->save())
	        {               
	            $this->redirect(array('index'));            	      
	        }
	        else
	        {
                Yii::app()->user->setFlash('error', "Error creating a mailtemplate record.'");
	        }
	            
	    }
	    
	    // Show the details screen
	    $this->render('details',array('model'=>$mailtemplateModel));

	}


	/**
	 * Updates an existing mailtemplate record.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the requested mailtemplate's
	 * ...   details capture form
	 * ... - the (subsequent) POST request saves the submitted post data for
	 * ...   the existing MailTemplate record
	 * ...If the save (POST request) is successful, the default method (index()) is called.
	 * ...If the save (POST request) is not successful, the details form is shown
	 * ...again with error messages from the MailTemplate validation (MailTemplate::rules())
	 * 
	 * @param integer $template_id the ID of the model to be updated
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionEdit($template_id)
	{
	    
		$mailtemplateModel = MailTemplate::model()->findByPk((int)$template_id);
		if($mailtemplateModel===null)
		{
		    throw new CHttpException(404,'The requested page does not exist.');		    
		}


		// Uncomment the following line if AJAX validation is needed
		// TODO: Currently disabled as it breaks JQuery loading order
		// $this->performAjaxValidation($mailtemplateModel);

		if(isset($_POST['MailTemplate']))
		{
            // Assign all fields from the form
		    $mailtemplateModel->attributes=$_POST['MailTemplate'];
		    
		    if($mailtemplateModel->save())
		    {
		    
		        $this->redirect(array('index'));
		    
		    }
		    else
		    {
		        Yii::app()->user->setFlash('error', "Error creating a mailtemplate record.'");
		    }
				
		}

	    $this->render('details',array('model'=> $mailtemplateModel));
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
	 * Show all events. Renders the event listing view.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionList()
	{
	    $dataProvider=new CActiveDataProvider('MailTemplate');
	    $this->render('list', array(
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
        $limitStart 	           = isset($_POST['start'])?(int)$_POST['start']:0;
        $limitItems 	           = isset($_POST['length'])?(int)$_POST['length']:Yii::app()->params['PAGESIZEREC'];
        
        $searchCriteria->limit 		 = $limitItems;
        $searchCriteria->offset 	 = $limitStart;
                        
         if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
         {             
             $searchCriteria->addSearchCondition('t.mailtemplate_name', $_POST['search']['value'], true);                          
         }
        
        
        $lstMailTemplate    = MailTemplate::model()->findAll($searchCriteria);
        
        $countRows 		= MailTemplate::model()->count($searchCriteria);;
        $totalRecords 		= MailTemplate::model()->count();
       
        /*
         * Output
         */
        $jsonOutput = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $totalRecords,
            "aaData"                => array()
        );
        
        foreach($lstMailTemplate as $recTemplate){
            
            $recRow = array( $recTemplate->attributes['template_id'],
                             $recTemplate->attributes['template_name'],
                         ''
                        );
            $jsonOutput['aaData'][] = $recRow;

        }
        
         
        echo json_encode($jsonOutput);
	    
	    
	}


	/**
	 * Performs the AJAX validation.
	 *
	 * @param MailTemplate $mailtemplateModel the model to be validated
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
	
	
}
