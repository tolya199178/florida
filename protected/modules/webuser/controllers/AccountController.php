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

    public 	$layout='//layouts/front';


    /**
     * @var string imagesDirPath Directory where User images will be stored
     * @access private
     */
    private $imagesDirPath;

    /**
     * @var string imagesDirPath Directory where User image thumbnails will be stored
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
        $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/user';
        $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/user/thumbnails';

        /*
         *     Small-s- 100px(width)
         *     Medum-m- 240px(width)
         *     Large-l- 600px(width)
         */
    }

    /**
     * Controller overwrite routines to set up the available actions
     *
     * @param <none> <none>
     *
     * @return array action list
     * @access public
     */
    public function actions(){
        return array(
            // captcha action renders the CAPTCHA image displayed on the user registration page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
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

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form')
        {
            echo CActiveForm::validate(array($formModel));
            Yii::app()->end();
        }

        if (isset($_POST['ProfileForm']))
        {

            $formModel->setAttributes($_POST['ProfileForm']);
            $formModel->user_name = $formModel->email;

            if ($formModel->validate())
            {

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
                $userModel->places_visited      = serialize($_POST['ProfileForm']['places_visited']);
                $userModel->places_want_to_visit = serialize($_POST['ProfileForm']['places_want_to_visit']);


                // Create a verification code, before the entry is saved
                $userModel->activation_code = HAccount::getVerificationCode(CHtml::encode($userModel->email));

                $uploadedFile = CUploadedFile::getInstance($formModel, 'picture');

                if ($userModel->validate() && $formModel->validate())
                {

                    if ($userModel->save())
                    {
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

                    }
                    else
                    {
                        Yii::app()->user->setFlash('error', "Error creating a user record.'");
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('error', "Validation error.'");
                }
            }
            else
            {
                Yii::app()->user->setFlash('error', "Validation error.'");
            }
        }

        $this->render('user_register', array('model' => $formModel));

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
	    throw new CHttpException(400,'Invalid Request.');

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

	/**
	 * Process the user profile edit action.
	 * ...
	 * ...The function is only available to logged in users. All other users are
	 * ...directed to a login screen.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionManageprofile()
	{

	    // /////////////////////////////////////////////////////////////////////
	    // Redirect non-logged in users to the login page
	    // /////////////////////////////////////////////////////////////////////
	    if (Yii::app()->user->isGuest)         // User is not logged in
	    {
            $this->redirect("login");
	        Yii::app()->end();
	    }

	    // /////////////////////////////////////////////////////////////////////
	    // Get the login details from the WebUser component
	    // /////////////////////////////////////////////////////////////////////
        $userId = Yii::app()->user->id;

        if ($userId === null)         // User is not known
        {
            $this->redirect("login");
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////////
        // Load the user details
        // /////////////////////////////////////////////////////////////////////
        $userModel = User::model()->findByPk($userId);
        if ($userModel === null) {
            $this->redirect("login");
        }

        // /////////////////////////////////////////////////////////////////////
        // Phew. If we made it here, then process the form request.
        // /////////////////////////////////////////////////////////////////////


	    $formModel = new ProfileForm;

	    $formModel->user_id                      = $userModel->attributes['user_id'];

	    $formModel->user_name                    = $userModel->attributes['user_name'];
	    $formModel->email                        = $userModel->attributes['email'];
	    $formModel->first_name                   = $userModel->attributes['first_name'];
	    $formModel->last_name                    = $userModel->attributes['last_name'];
	    $formModel->places_want_to_visit         = $userModel->attributes['places_want_to_visit'];

	    $formModel->date_of_birth                = $userModel->attributes['date_of_birth'];
	    $formModel->mobile_carrier_id            = $userModel->attributes['mobile_carrier_id'];
	    $formModel->mobile_number                = $userModel->attributes['mobile_number'];
	    $formModel->hometown                     = $userModel->attributes['hometown'];
	    $formModel->marital_status               = $userModel->attributes['marital_status'];
	    $formModel->send_sms_notification        = $userModel->attributes['send_sms_notification'];
	    $formModel->my_info_permissions          = $userModel->attributes['my_info_permissions'];
	    $formModel->photos_permissions           = $userModel->attributes['photos_permissions'];
	    $formModel->friends_permissions          = $userModel->attributes['friends_permissions'];
	    $formModel->blogs_permissions            = $userModel->attributes['blogs_permissions'];
	    $formModel->travel_options_permissions   = $userModel->attributes['travel_options_permissions'];

	    if (isset($_POST['ProfileForm']))
	    {

	        $formModel->setAttributes($_POST['ProfileForm']);
	        $formModel->user_name = $formModel->email;

	        if ($formModel->validate())
	        {

	            // Copy form details
	            $userModel->setAttributes($_POST['ProfileForm']);

	            // Add additional fields
	            $userModel->password            = isset($_POST['ProfileForm']['password'])?$_POST['ProfileForm']['password']:null;
	            $userModel->fldVerifyPassword   = isset($_POST['ProfileForm']['confirm_password'])?$_POST['ProfileForm']['confirm_password']:null;
	            $userModel->created_by          = 1;
	            $userModel->user_name           = $userModel->email;
	            $userModel->places_visited      = serialize($_POST['ProfileForm']['places_visited']);
	            $userModel->places_want_to_visit = serialize($_POST['ProfileForm']['places_want_to_visit']);

	            // Make a note of the existing image file name. It will be deleted soon.
	            $oldImageFileName = $userModel->image;

	            $uploadedFile = CUploadedFile::getInstance($formModel, 'fldUploadImage');

	            if ($userModel->validate() && $formModel->validate())
	            {

	                if ($userModel->save())
	                {

	                    if (!empty($uploadedFile))
	                    {
	                        $imageFileName = 'user-' . $userModel->user_id . '-' . $uploadedFile->name;
	                        $imagePath     = $this->imagesDirPath . DIRECTORY_SEPARATOR . $imageFileName;

	                        // Remove existing images
	                        if (!empty($oldImageFileName))
	                        {
	                            $this->deleteImages($oldImageFileName);
	                        }

                            $uploadedFile->saveAs($imagePath);
                            $userModel->image = $imageFileName;

                            $this->createThumbnail($imageFileName);

                            $userModel->save();

	                    }

	                    $this->redirect("dashboard/dashboard/");

	                    Yii::app()->end();

	                } else {
	                    Yii::app()->user->setFlash('error', "Error creating a business record.'");
	                }
	            }
	        }
	    }


	    // /////////////////////////////////////////////////////////////////////
	    // Get a list of the user's friends
	    // /////////////////////////////////////////////////////////////////////
	    // /////////////////////////////////////////////////////////////////////
	    // First, get a list of all local friends
	    // /////////////////////////////////////////////////////////////////////
	    $lstMyFriends = MyFriend::model()->with('friend')->findAllByAttributes(array(
	        'user_id' => Yii::app()->user->id
	    ));

	    // /////////////////////////////////////////////////////////////////////
	    // Now, get a list of the user's facebook friends
	    // /////////////////////////////////////////////////////////////////////
	    // Load the component
	    // TODO: figure why component is not autoloading.
	    $objFacebook = Yii::app()->getComponent('facebook');

	    // Establish a connection to facebook
	    $objFacebook->connect();

	    $lstMyOnlineFriends = array();
	    if ($objFacebook->isLoggedIn()) {
	        $lstMyOnlineFriends = $objFacebook->getFriendList();
	    }

	    // /////////////////////////////////////////////////////////////////////
	    // Get the user's messages
	    // /////////////////////////////////////////////////////////////////////
	    $listMessages = UserMessage::model()->findAllByAttributes(array('recipient' => Yii::app()->user->id));

	    // /////////////////////////////////////////////////////////////////////
	    // Get a list of the user's images
	    // /////////////////////////////////////////////////////////////////////
	    $listPhotos = Photo::model()->findAllByAttributes(array('entity_id' => Yii::app()->user->id, 'photo_type' => 'user'));

	    $this->render('user_profile', array('model'            => $formModel,
	                                        'myLocalFriends'   => $lstMyFriends,
	                                        'myOnlineFriends'  => $lstMyOnlineFriends,
	                                        'myMessages'       => $listMessages,
	                                        'myPhotos'         => $listPhotos,
	                                       ));
	}

	/**
	 * Process the user login action via facebook
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionFblogin()
	{

	    // if the user is already logged in, there is no need to do anything.
	    if (!Yii::app()->user->isGuest)         // User is already logged in
	    {
	        $this->redirect(Yii::app()->user->returnUrl);
	        Yii::app()->end();
	    }

	    $objFacebook  = Yii::app()->getComponent('facebook');

	    // Establish a connection to facebook
	    $objFacebook->connect();

	    $userIdentity = new FBIdentity("", "");
	    if ($userIdentity->authenticate() != FBIdentity::ERROR_NONE)
	    {

	        $this->redirect($objFacebook->getLoginUrl());
	    }
	    else
	    {

	        // Otherwise we have a good login
	        $loginDuration = 3600*24*30; // 30 days
	        Yii::app()->user->login($userIdentity, $loginDuration);

	        $this->redirect(Yii::app()->user->returnUrl);

	    }




	}

	/**
	 * Process the user login action via facebook
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionFblogout()
	{
	    // Load the component
	    // TODO: figure why component is not autoloading.
	    $objFacebook  = Yii::app()->getComponent('facebook');

	    // Establish a connection to facebook
	    $objFacebook->connect();
	    $objFacebook->logout();

	    Yii::app()->user->logout();

	    if ($objFacebook->isLoggedIn())
	    {
	        $this->redirect($objFacebook->getLogoutUrl());

	    }
	}

}