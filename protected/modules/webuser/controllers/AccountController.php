<?php

/**
 * Account Controller interface for the Frontend (Public) User Module
 */


/**
 * AccountController is a class to provide access to controller actions for general
 * ..processing of user account actions. The contriller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/webuser/account/login/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/webuser/account/login/name/toms-diner/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /webuser/account/login/name/toms/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /webuser/account/login/name/toms/ will pass $_GET['name'] = 'toms'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class AccountController extends Controller
{
    
    
    /**
     * @var string imagesDirPath Directory where Business images will be stored
     * @access private
     */
    private $imagesDirPath;
    
    /**
     * @var string imagesDirPath Directory where Business image thumbnails will be stored
     * @access private
     */
    private $thumbnailsDirPath;
    
    /**
     * @var string thumbnailWidth thumbnail width
     * @access private
     */
    private $thumbnailWidth     = 100;
    /**
     * @var string thumbnailWidth thumbnail width
     * @access private
     */
    private $thumbnailHeight    = 100;
    
    /**
     * Controller initailisation routines to set up the controller
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
     */
    public function init()
    {
        $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/business';
        $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/business/thumbnails';
    
        /*
         *     Small-s- 100px(width)
        *     Medum-m- 240px(width)
        *     Large-l- 600px(width)
        */
    }
    
    /**
     * Register a new user
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionRegister()
	{
        $formModel = new ProfileForm('register');
        
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
            echo CActiveForm::validate(array(
                $model
            ));
            Yii::app()->end();
        }
        
        if (isset($_POST['ProfileForm'])) {
            
            $formModel->setAttributes($_POST['ProfileForm']);
            $formModel->user_name = $formModel->email;
            
            if ($formModel->validate()) {
                
                // /////////////////////////////////////////////////////////////////
                // Create a new user entry
                // /////////////////////////////////////////////////////////////////
                $userModel = new User();
                $userModel->scenario = User::SCENARIO_REGISTER;
                
                // Copy form details
                $userModel->setAttributes($_POST['ProfileForm']);
                
                // Add additional fields
                $userModel->password            = $_POST['ProfileForm']['password'];
                $userModel->fldVerifyPassword   = $_POST['ProfileForm']['confirm_password'];
                $userModel->created_by          = 1;
                $userModel->user_name           = $userModel->email;
                $userModel->status              = 'inactive';
                $userModel->activation_status   = 'not_activated';

                
                // Create a verification code, before the entry is saved
                $userModel->activation_code = HAccount::getVerificationCode(CHtml::encode($userModel->email));
                
                $uploadedFile = CUploadedFile::getInstance($formModel, 'picture');
                
                if ($userModel->validate() && $formModel->validate()) {
                    
                    if ($userModel->save()) {
                        if (!empty($uploadedFile))
                        {
                            $imageFileName = 'user-' . $userModel->user_id . '-' . $uploadedFile->name;
                            $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $imageFileName;
                            
                            if (! empty($uploadedFile))                         // check if uploaded file is set or not
                            {
                                $uploadedFile->saveAs($imagePath);
                                $userModel->image = $imageFileName;
                            
                                $this->createThumbnail($imageFileName);
                            
                                $userModel->save();
                            }
                        }
                        
                        // Get the email message and subject
                        $emailMessage = HAccount::getEmailMessage('verification_email');
                        $emailSubject = HAccount::getEmailSubject('verification_email');
                        
                        
                        // Customise the email message
                        $emailMessage = HAccount::CustomiseMessage($emailMessage, $userModel->attributes);
                        
                        
                        // Send the message
                        HAccount::sendMessage($userModel->attributes['email'], $userModel->attributes['first_name'].' '.$userModel->attributes['last_name'], $emailSubject, $emailMessage);

                        
                        $this->render('register_thanks', array('model' => $formModel));                        
                        
                        
                        Yii::app()->end();
                        
                    } else {
                        Yii::app()->user->setFlash('error', "Error creating a business record.'");
                    }
                }
            }
        }   
        
        $this->render('user_profile', array('model' => $formModel));
		
	}
	
	/**
	 * Process the user login action.
	 * ...The function is normally invoked twice:
	 * ... - the (initial) GET request loads and renders the login form
	 * ... - the (subsequent) POST request processes the login request.
	 * ...If the save (POST request) is successful, the user is directed back to
	 * ...the calling url
	 * ...If the save (POST request) is not successful, the login form is shown
	 * ...again with error messages from the loginform validation (Loginform::rules())
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionLogin()
	{
	    $modelLoginForm = new LoginForm();
	    
	    // NOTE; To process ajax requests, check (Yii::app()->request->isAjaxRequest == 1)

	    // collect user input data
	    if (isset($_POST['LoginForm'])) {
	
	        $modelLoginForm->attributes = $_POST['LoginForm'];
	
	        // validate user input and redirect to the previous page if valid
	        if ($modelLoginForm->validate() && $modelLoginForm->login()) {
	            
	            // Send back a JSON request for Ajax submissions
	            if (Yii::app()->request->isAjaxRequest == 1)
	            {
	                header("Content-type: application/json");
	                echo CJSON::encode(array(
	                    'authenticated'    => true,
	                    'redirectUrl'      => Yii::app()->user->returnUrl,
	                ));
	                Yii::app()->end();  
	            }
	
	            // For normal page submissions, redirect
	            $this->redirect(Yii::app()->user->returnUrl);
	        }
	        else {
	            
	            // Send back a JSON request for Ajax submissions
	            if (Yii::app()->request->isAjaxRequest == 1)
	            {
	                header("Content-type: application/json");
	                echo CJSON::encode(array(
	                    'authenticated'    => false,
	                    'redirectUrl'      => Yii::app()->user->returnUrl,
	                ));
	                Yii::app()->end();
	            }
	            
	            // For normal page submissions, redirect
	            $this->redirect(Yii::app()->user->returnUrl);
	            
	        }
	    }
	
        // If we got here, then this is an invalid request. Die quitely
	    Yii::app()->end();
	}
	
	/**
	 * Process the user activation action.
	 * ...This action is normally generated from an email that is sent to the
	 * ...user.
	 * ...
	 * ...The user account is checked against the activation code and if there
	 * ...is a match, the user account is marked as activated.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionActivate()
	{
	    	    
	    $actionvationCode  = Yii::app()->request->getParam('cde');
	    
	    // Find the corresponding user record.
	    $userRecord = User::model()->findByAttributes(array('activation_code' => $actionvationCode));
	    
	    if ($userRecord === null)
	    {
	        throw new CHttpException(405,'There was a problem obtaining the user record.');
	    }
	    
	    // If we are here, then we have a good record. Update the active status and save the entry.
	    $userRecord->scenario              = User::SCENARIO_VALIDATION;
	    
	    $userRecord['activation_status']   = 'activated';
	    
        if($userRecord->save())
        {
            
            $this->render('welcome_validated_user', array('model' => $userRecord));

        }
        else
        {
            Yii::app()->user->setFlash('error', "Error activating your account.");
            $this->render('invalid_activation', array('model' => $userRecord));
            
        }
	    
	    
	}
		
}