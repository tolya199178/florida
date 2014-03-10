<?php

/**
 * Controller interface for the Backend Site Module
 */


/**
 * Site Controller class to provide access to controller actions for general
 * ...rendering of site. The contriller action interfaces 'directly' with the
 * ...Client, and must therefore be responsible for input processing and 
 * ...response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/user/site/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/site/login/my_name/tom/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /site/login/my_name/tom/ will invoke UserController::actionLogin()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /site/login/my_name/tom/ will pass $_GET['my_name'] = tom
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class SiteController extends BackEndController
{

    /**
     * Specify class-based actions. Specifies external (files or other classes
     * ...for action handlers. This allows the controller to redirect the action
     * ...another class for handing,
     *
     * @param <none> <none>
     *
     * @return array action specifiers
     * @access public
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction'
            )
        );
    }

    /**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by users.
     * 
     * Does not perform any processing. Redirects to the desired action instead.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {
        // Default action is to show all users.
        $this->redirect( array('dashboard') );
    }


    /**
     * This is the action to handle external exceptions.
     * This action is configured in the application config, and serves as default
     * ...error handler. It renders an error message using the site layout.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionError()
    {
        
        if ($error = Yii::app()->errorHandler->error) {

            // /////////////////////////////////////////////////////////////////
            // Only send the error message for Ajax requests, otherwise render
            // ...the error message into the application layout.
            // /////////////////////////////////////////////////////////////////
            if (Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $this->render('error', array(
                    'error' => $error
                ));
            }
        }
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
        $model = new LoginForm();
        
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            $errors = CActiveForm::validate($model);
            if ($errors != '[]') {
                echo $errors;
                Yii::app()->end();
            }
        }
        
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            
            $model->attributes = $_POST['LoginForm'];
            
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
                    echo CJSON::encode(array(
                        'authenticated' => true,
                        'redirectUrl' => Yii::app()->user->returnUrl,
                        "param" => "Any additional param"
                    ));
                    Yii::app()->end();
                }
                
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        
        // display the login form with a different layout to the site.
        $this->layout = '//layouts/blank';
        
        $this->render('login', array(
            'model' => $model
        ));
    }

    /**
     * Renders the application dashboard.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionDashboard()
    {
                
        $this->render('/site/dashboard');
    }


    /**
     * Logs out the current user and redirect to homepage.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}