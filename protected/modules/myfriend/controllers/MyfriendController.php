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
 * ...   http://application.domain/index.php?/myfriend/myfriend/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/myfriend/myfriend/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /myfriend/myfriend/show/name/toms/ will invoke MyFriendController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /myfriend/myfriend/show/name/toms/ will pass $_GET['name'] = 'tom'
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
		    throw new CHttpException(400, 'This functionality is only avalable to logged in users.');
		    Yii::app()->end();
		}

		// Load the component
		// TODO: figure why component is not autoloading.
		$objFacebook  = Yii::app()->getComponent('facebook');

		// Establish a connection to facebook
		$objFacebook->connect();

		if ($objFacebook->isLoggedIn())
		{
		      $objFacebook->getFriendList();
		}
		else
		{
		    throw new CHttpException(400, 'You must be logged in via facebook.');
		    Yii::app()->end();

		}


	}

	/**
	 * Finds friend, and pending friend requests received and sent
	 *
	 * @param  <none> <none>
	 *
	 * @return Array The set of lists of users by category.
	 * @access private
	 */
	private function getFriendLists()
	{

	    $setFriendListing = array();

	    // /////////////////////////////////////////////////////////////////////
	    // First, get a list of all local friends
	    // /////////////////////////////////////////////////////////////////////
	    $lstMyFriends   = MyFriend::model()
                            	  ->with('friend')
                                  ->findAllByAttributes(array('user_id' => Yii::app()->user->id));

	    $setFriendListing['lstMyFriends']      = $lstMyFriends;


	    // /////////////////////////////////////////////////////////////////////
	    // Now, get a list of the user's facebook friends
	    // /////////////////////////////////////////////////////////////////////
	    // Load the component
	    // TODO: figure why component is not autoloading.
	    $objFacebook                           = Yii::app()->getComponent('facebook');

	    // Establish a connection to facebook
	    $objFacebook->connect();

	    $lstMyOnlineFriends                    = array();
	    if ($objFacebook->isLoggedIn())
	    {
	       $lstMyOnlineFriends                    = $objFacebook->getFriendList();
	    }

	    $setFriendListing['lstMyOnlineFriends']  = $lstMyFriends;


	    // /////////////////////////////////////////////////////////////////////
	    // Next, get a list of all pending requests
	    // /////////////////////////////////////////////////////////////////////
	    $lstFriendRequestsReceived     = MyFriend::model()
                                                 ->with('user')
                                                 ->findAllByAttributes(array('friend_id'    => Yii::app()->user->id,
                                                                             'friend_status'=>'Pending'));

        $setFriendListing['lstMyFriendsRequestsReceived']  = $lstFriendRequestsReceived;

        return $setFriendListing;

	}

}