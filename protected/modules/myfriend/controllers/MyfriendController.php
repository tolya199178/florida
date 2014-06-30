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

    const FRIEND_STATUS_BLOCK   = 1;
    const FRIEND_STATUS_UNBLOCK = 2;


    public 	$layout='//layouts/front';

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
	 * Displays friend lists
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

        /*
         * Get the main dashboard component
         */
        $argComponent = Yii::app()->request->getQuery('component', 'default');

        $lstMyFriends = array();
        $lstMyOnlineFriends = array();
        $myFriendsCount = array();


        // /////////////////////////////////////////////////////////////////////
        // Get a list of the user's friends
        // /////////////////////////////////////////////////////////////////////
        $listMyFriends = $this->getFriendLists();

        $resultsFriendSummary = MyFriend::FriendSummary(Yii::app()->user->id);
        $userFriendSummary = array_pop($resultsFriendSummary);

        $myFriendsCount['allfriends'] = $userFriendSummary['approved'];
        $myFriendsCount['onlinefriends'] = 0;
        $myFriendsCount['sentfriendrequests'] = $userFriendSummary['pending'];
        $myFriendsCount['receivedfriendrequests'] = count(MyFriend::model()->findAllByAttributes(array(
                                                                                'friend_id' => Yii::app()->user->id,
                                                                                'friend_status' => 'pending'
                                                                             )));

        // Show the dashboard
        $this->render('myfriend_main', array(
                      'mainview'        => 'myfriends',
                      'data'            => array(
                                              'listMyFriends'   => $listMyFriends,
                                              'myFriendsCount'  => $myFriendsCount
                                           )
                ));

	}

	/**
	 * Block a user from sending messages or receiving alerts to the logged in user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionBlockuser()
	{

	    $this->doBlockUnblockuser($this::FRIEND_STATUS_BLOCK);



// 	    // /////////////////////////////////////////////////////////////////////
// 	    // Redirect non-logged in users to the login page
// 	    // /////////////////////////////////////////////////////////////////////
// 	    if (Yii::app()->user->isGuest)         // User is not logged in
// 	    {
// 	        $this->redirect("login");
// 	        Yii::app()->end();
// 	    }

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // Get the login details from the WebUser component
// 	    // /////////////////////////////////////////////////////////////////////
// 	    $userId = Yii::app()->user->id;

// 	    if ($userId === null)         // User is not known
// 	    {
// 	        $this->redirect("login");
// 	        Yii::app()->end();
// 	    }

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // Load the user details
// 	    // /////////////////////////////////////////////////////////////////////
// 	    $userModel = User::model()->findByPk($userId);
// 	    if ($userModel === null) {
// 	        $this->redirect("login");
// 	    }

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // We can only block 'true friends'
// 	    // /////////////////////////////////////////////////////////////////////
// 	    if (isset($_GET['friend']))
// 	    {

// 	        $friendId = $_GET['friend'];
// 	        /*
// 	         * Validate the friend id, and check that the record is pointing to a true friend
// 	        */
// 	        $friendModel = MyFriend::model()->findByPk( (int) $_GET['friend']);

// 	        if ($friendModel && ($friendModel->user_id == Yii::app()->user->id))
// 	        {

// 	            $friendModel->friend_status = 'Blocked';

// 	            if ($friendModel->save())
// 	            {
// 	                Yii::app()->user->setFlash('warning','User is blocked. You will not receive further messages from this user.');
// 	                $this->redirect(array('/myfriend/'));
// 	                Yii::app()->end();

// 	            }
// 	            else
// 	            {
// 	                Yii::app()->user->setFlash('warning','Your request could not be handled at this time. Try again later.
// 	                                           Contact the administrator if the problem persists.');
// 	                $this->redirect(array('/myfriend/'));
// 	                Yii::app()->end();
// 	            }

// 	        }
// 	        else
// 	        {
// 	            Yii::app()->user->setFlash('error','You cannot block this user.');
// 	            $this->redirect(array('/myfriend/'));
// 	            Yii::app()->end();
// 	        }
// 	    }


	}

	/**
	 * Unblock a user to all sending messages or receiving alerts to the logged in user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionUnblockuser()
	{


	    $this->doBlockUnblockuser($this::FRIEND_STATUS_UNBLOCK);

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // Redirect non-logged in users to the login page
// 	    // /////////////////////////////////////////////////////////////////////
// 	    if (Yii::app()->user->isGuest)         // User is not logged in
// 	    {
// 	        $this->redirect("login");
// 	        Yii::app()->end();
// 	    }

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // Get the login details from the WebUser component
// 	    // /////////////////////////////////////////////////////////////////////
// 	    $userId = Yii::app()->user->id;

// 	    if ($userId === null)         // User is not known
// 	    {
// 	        $this->redirect("login");
// 	        Yii::app()->end();
// 	    }

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // Load the user details
// 	    // /////////////////////////////////////////////////////////////////////
// 	    $userModel = User::model()->findByPk($userId);
// 	    if ($userModel === null) {
// 	        $this->redirect("login");
// 	    }

// 	    // /////////////////////////////////////////////////////////////////////
// 	    // We can only block 'true friends'
// 	    // /////////////////////////////////////////////////////////////////////
// 	    if (isset($_GET['friend']))
// 	    {

// 	        $friendId = $_GET['friend'];
// 	        /*
// 	         * Validate the friend id, and check that the record is pointing to a true friend
// 	        */
// 	        $friendModel = MyFriend::model()->findByPk( (int) $_GET['friend']);

// 	        if ($friendModel && ($friendModel->user_id == Yii::app()->user->id))
// 	        {

// 	            $friendModel->friend_status = 'Blocked';

// 	            if ($friendModel->save())
// 	            {
// 	                Yii::app()->user->setFlash('warning','User is blocked. You will not receive further messages from this user.');
// 	                $this->redirect(array('/myfriend/'));
// 	                Yii::app()->end();

// 	            }
// 	            else
// 	            {
// 	                Yii::app()->user->setFlash('warning','Your request could not be handled at this time. Try again later.
// 	                                           Contact the administrator if the problem persists.');
// 	                $this->redirect(array('/myfriend/'));
// 	                Yii::app()->end();
// 	            }

// 	        }
// 	        else
// 	        {
// 	            Yii::app()->user->setFlash('error','You cannot block this user.');
// 	            $this->redirect(array('/myfriend/'));
// 	            Yii::app()->end();
// 	        }
// 	    }


	}

	/**
	 * Block a user from sending messages or receiving alerts to the logged in user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	private function doBlockUnblockuser($blockAction)
	{

	    if (($blockAction !== $this::FRIEND_STATUS_BLOCK) && ($blockAction !== $this::FRIEND_STATUS_UNBLOCK))
	    {
	        throw new CHttpException(404, 'Unauthorised Access Attempt. Please do not repeat this request.');
	    }

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
	    // We can only block 'true friends'
	    // /////////////////////////////////////////////////////////////////////
	    if (isset($_GET['friend']))
	    {

	        $friendId = $_GET['friend'];
	        /*
	         * Validate the friend id, and check that the record is pointing to a true friend
	        */
	        $friendModel = MyFriend::model()->findByPk( (int) $_GET['friend']);

	        if ($friendModel && ($friendModel->user_id == Yii::app()->user->id))
	        {

	            if ($blockAction == $this::FRIEND_STATUS_BLOCK)
	            {
	                $friendModel->friend_status = 'Blocked';
	                $flashMessage      = 'User is blocked. You will not receive further messages from this user.';
	                $flashMessageType  = 'warning';
	            }
	            else if ($blockAction == $this::FRIEND_STATUS_UNBLOCK)
	            {
	                $friendModel->friend_status = 'Approved';
	                $flashMessage      = 'User is unblocked. You will be able to receive messages from this user.';
	                $flashMessageType  = 'warning';
	            }



	            if ($friendModel->save())
	            {
	                Yii::app()->user->setFlash($flashMessageType, $flashMessage);
	                $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	                Yii::app()->end();

	            }
	            else
	            {
	                Yii::app()->user->setFlash('warning','Your request could not be handled at this time. Try again later.
	                                           Contact the administrator if the problem persists.');
	                $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	                Yii::app()->end();
	            }

	        }
	        else
	        {

	            if ($blockAction = $this::FRIEND_STATUS_BLOCK)
	            {
	                $flashMessage      = 'You cannot block this user.';
	            }
	            else if ($blockAction = $this::FRIEND_STATUS_UNBLOCK)
	            {
	                $flashMessage      = 'You cannot unblock this user.';
	            }

	            Yii::app()->user->setFlash('error','You cannot block this user.');
	            $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	            Yii::app()->end();
	        }
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