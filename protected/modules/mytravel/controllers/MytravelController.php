<?php

/**
 * Mytravel Controller interface for the Frontend (Public) Mytravels Module
 */


/**
 * MytravelController is a class to provide access to controller actions for general
 * ..processing of user friends actions. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/mytravel/mytravel/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/mytravel/mytravel/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /mytravel/mytravel/show/name/toms/ will invoke MyFriendController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /mytravel/mytravel/show/name/toms/ will pass $_GET['name'] = 'tom'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class MytravelController extends Controller
{


    public 	$layout='//layouts/front';

    /**
     * Default controller action.
     * Shows the my travel dashboard page
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{

	    $this->redirect(array('/mytravel/mytravel/show'));

	    Yii::app()->end();

	}

	/**
	 * Displays travel dashboard
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionShow()
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

        $dbCriteria             = new CDbCriteria;
        $dbCriteria->condition  = 'user_id = :user_id';
        $dbCriteria->params     = array(':user_id'=>Yii::app()->user->id);
        $dbCriteria->limit      = 10;
        $dbCriteria->order      = 'created_date  DESC';

        $lstMyTrips = Trip::model()->findAll($dbCriteria);



        // Show the dashboard
        $this->render('mytravel_main', array(
                      'mainview'        => 'mytravels',
                      'data'            => array('myTrips'   => $lstMyTrips)
                ));

	}


}