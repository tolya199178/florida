<?php

/**
 * Myfriend Controller interface for the Frontend (Public) Myfriends Module
 */


/**
 * MyfriendController is a class to provide access to controller actions for general
 * ..processing of user friends actions. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/webuser/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/webuser/profile/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /business/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /business/profile/show/name/toms/ will pass $_GET['name'] = 'toms'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class MyfriendController extends Controller
{

    /**
     * Default controller action.
     * Shows the listing of friends
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{

		$userId = Yii::app()->user->id;

		if ($userId === null)         // User is not known
		{
		    $jsonResult = '{"result":false,"message":"This functionality is only avalable to logged in users."}';
		    header('Content-Type: application/json');
		    echo CJSON::encode($jsonResult);
		    Yii::app()->end();
		}

		// Load the component
		// TODO: figure why component is not autoloading.
		$objFacebook  = Yii::app()->getComponent('facebook');

		// Establish a connection to facebook
		$objFacebook->connect();


	}


}