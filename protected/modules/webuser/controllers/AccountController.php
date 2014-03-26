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
            
            if ($formModel->validate()) {
                
                // /////////////////////////////////////////////////////////////////
                // Create a new user entry
                // /////////////////////////////////////////////////////////////////
                $userModel = new User();
                $userModel->scenario = User::SCENARIO_REGISTER;
                
                // Copy form details
                $userModel->setAttributes($_POST['ProfileForm']);
                $formModel->setAttributes($_POST['ProfileForm']);
                
                // Add additional fields
                $userModel->password = $_POST['ProfileForm']['password'];
                $userModel->fldVerifyPassword = $_POST['ProfileForm']['confirm_password'];
                $userModel->created_by = 1;
                $userModel->user_name = $userModel->email;
                $userModel->status = 'inactive';
                $userModel->activation_status = 'not_activated';
                $userModel->activation_code = '0xDEADFEED';
                
                $formModel->user_name = $formModel->email;
                
                $uploadedFile = CUploadedFile::getInstance($formModel, 'picture');
                
                if ($userModel->validate() && $formModel->validate()) {
                    
                    if ($userModel->save()) {
                        $imageFileName = 'user-' . $userModel->user_id . '-' . $uploadedFile->name;
                        $imagePath = $this->imagesDirPath . DIRECTORY_SEPARATOR . $imageFileName;
                        
                        if (! empty($uploadedFile))                         // check if uploaded file is set or not
                        {
                            $uploadedFile->saveAs($imagePath);
                            $userModel->image = $imageFileName;
                            
                            $this->createThumbnail($imageFileName);
                            
                            $userModel->save();
                        }
                        
                        $this->redirect(array(
                            'index'
                        ));
                    } else {
                        Yii::app()->user->setFlash('error', "Error creating a business record.'");
                    }
                }
            }
        }
        
        $this->render('user_profile', array('model' => $formModel));
		
	}
	
}