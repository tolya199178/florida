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
	 * Remove a previously issued request to connect to another user.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionFriendrequest()
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

	    $argFriendId = Yii::app()->request->getQuery('friend', 'default');

	    // /////////////////////////////////////////////////////////////////////
	    // Search for the friend record
	    // /////////////////////////////////////////////////////////////////////
	    $modelFriend = User::model()->findbyPK($argFriendId);

	    if ($modelFriend === null)
	    {
	        $errMsg = 'Something went wrong. The requested user was not found. Try again later';
	        Yii::app()->user->setFlash('error', $errMsg);
	        $this->redirect(YII::app()->request->urlReferrer);
	        Yii::app()->end();
	    }

	    // /////////////////////////////////////////////////////////////////////
	    // Check for an existing friend relationship betwewn the two users
	    // /////////////////////////////////////////////////////////////////////
	    $modelMyFriend = MyFriend::model()->findByAttributes(array(
	        'user_id'      => $userId,
	        'friend_id'    => $argFriendId
	    ));

	    if ($modelMyFriend != null)
	    {
	        $errMsg = 'We found an existing '.$modelMyFriend->friend_status.' request for the user.';
	        Yii::app()->user->setFlash('warning', $errMsg);
	        $this->redirect(YII::app()->request->urlReferrer);
	        Yii::app()->end();
	    }

	    // We can process the friend request
	    $modelMyFriend                 = new MyFriend;
	    $modelMyFriend->user_id        = $userId;
	    $modelMyFriend->friend_id      = $argFriendId;
	    $modelMyFriend->friend_status  = 'Pending';
	    $modelMyFriend->request_time   =  new CDbExpression('NOW()');

	    if (!$modelMyFriend->save())
	    {
	        $errMsg = 'We failed to send the friend request.';
	        Yii::app()->user->setFlash('error', $errMsg);
	        $this->redirect(YII::app()->request->urlReferrer);
	        Yii::app()->end();
	    }

        // Send the user an alert message

	    $msgSubject = 'You have received a friend request from '.Yii::app()->user->getFirstName();
	    $msgContent = 'You have received a friend request from '.Yii::app()->user->getFirstName()."\n".
	                  "Click on the link below to see the invitation \n".
	                   Yii::app()->createAbsoluteUrl('//myfriend/myfriend/show/allfriends/')."\n\n".
	                   "Best Regards\n"."Your florida.com team.";

	    MessageService::sendSystemMessage($argFriendId, 'Notice', $msgSubject, $msgContent);

	    Yii::app()->user->setFlash('success', 'Your connect request was submitted.');
	    $this->redirect(YII::app()->request->urlReferrer);
	    Yii::app()->end();
	}


	/**
	 * Remove a previously issued request to connect to another user.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionUnrequest()
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
        // We can only disconnect from users that we connected from.
        // /////////////////////////////////////////////////////////////////////
        if (isset($_GET['friend'])) {

            $friendId = $_GET['friend'];

            /*
             * Check if an existing friend entry already exists
             */
            $friendModel = MyFriend::model()->findByPk((int) $_GET['friend']);

            if ($friendModel && ($friendModel->user_id == Yii::app()->user->id))
            {

                if ($friendModel->friend_status != 'Pending')
                {
                    Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
                    $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                    Yii::app()->end();
                }
                else
                {
                    if ($friendModel->delete())
                    {
                        Yii::app()->user->setFlash('success', 'Your invitation request has been cancelled.');
                        $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                        Yii::app()->end();

                    }
                    else
                    {
                        Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
                        $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                        Yii::app()->end();

                    }
                }

            }
            else
            {
                Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
                $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                Yii::app()->end();
            }

		}

	}

	/**
	 * Reject a previously issued request to connect to the current user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionRejectrequest()
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
	    // We can only disconnect from users that we connected from.
	    // /////////////////////////////////////////////////////////////////////
	    if (isset($_GET['friend'])) {

	        $friendId = $_GET['friend'];

	        /*
	         * Check if an existing friend entry already exists
	        */
	        $friendModel = MyFriend::model()->findByPk((int) $_GET['friend']);

	        if ($friendModel && ($friendModel->friend_id == Yii::app()->user->id))
	        {

	            if ($friendModel->friend_status != 'Pending')
	            {
	                Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
	                $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	                Yii::app()->end();
	            }
	            else
	            {
	                if ($friendModel->delete())
	                {
	                    Yii::app()->user->setFlash('success', 'Your invitation request has been cancelled.');
	                    $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	                    Yii::app()->end();

	                }
	                else
	                {
	                    Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
	                    $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	                    Yii::app()->end();

	                }
	            }

	        }
	        else
	        {
	            Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
	            $this->redirect(array('/myfriend/myfriend/show/allfriends'));
	            Yii::app()->end();
	        }

	    }

	}

	/**
	 * Reject a previously issued request to connect to the current user
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAcceptrequest()
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
        // We can only disconnect from users that we connected from.
        // /////////////////////////////////////////////////////////////////////
        if (isset($_GET['friend'])) {

            $friendId = $_GET['friend'];

            /*
             * Check if an existing friend entry already exists
             */
            $friendModel = MyFriend::model()->findByPk((int) $_GET['friend']);

            if ($friendModel && ($friendModel->friend_id == Yii::app()->user->id))
            {

                if ($friendModel->friend_status != 'Pending')
                {
                    Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
                    $this->redirect(array('/myfriend/myfriend/show/allfriends'));
                    Yii::app()->end();
                }
                else
                {
                    $friendModel->friend_status = 'Approved';

                    if ($friendModel->save())
                    {
                        Yii::app()->user->setFlash('success', 'You are now connected.');
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

            }
            else
            {
                Yii::app()->user->setFlash('error', 'Record not found. Your request could not be processed.');
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

	/**
	 * Renders JSON results of friend search in {id,text,image} format.
	 * Used for dropdowns
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAutocompletelist()
	{

	    $strSearchFilter = $_GET['query'];

	    // Don't process short request to prevent load on the system.
	    if (strlen($strSearchFilter) < 2)
	    {
	        header('Content-type: application/json');
	        return "";
	        Yii::app()->end();

	    }

	    $lstFriend = Yii::app()->db
	    ->createCommand()
	    ->select('tbl_my_friend.my_friend_id as id, CONCAT(user.first_name," ",user.last_name) as text, user.image as image')
	    ->from('tbl_my_friend')
        ->join('tbl_user user', 'user.user_id=tbl_my_friend.friend_id')
	    ->where('tbl_my_friend.user_id = :user_id', array(':user_id'=>Yii::app()->user->id))
	    ->queryAll();

	    header('Content-type: application/json');
	    echo CJSON::encode($lstFriend);

	}

     /**
      * Renders join app request to FB friends.
      * Used for dropdowns
      *
      * @param <none> <none>
      *
      * @return <none> <none>
      * @access public
      */
     public function actionJoinapp()
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
         // Get a list of all local friends
         // /////////////////////////////////////////////////////////////////////
         $dbCriteria             = new CDbCriteria;

         $dbCriteria->condition  = "t.user_id      = :user_id AND
                                    friend.status  = 'inactive' AND
                                    t.connected_by = :connected_by";
         $dbCriteria->params     = array(':user_id'     => Yii::app()->user->id,
                                         ':connected_by'=> 'facebook');
         $lstMyFriends = MyFriend::model()->with('friend')->findAll($dbCriteria);

         $this->render("invite_joinapp", array(
             'myLocalFriends'    => $lstMyFriends
         ));


     }


     /**
      * Process notification of friend requests receieved by Facebook.
      * Used for dropdowns
      *
      * @param <none> <none>
      *
      * @return <none> <none>
      * @access public
      */
     public function actionNotifyjoinapp()
     {

         GamificationService::raiseEvent('INVITE_FRIENDS', Yii::app()->user->id);


     }


}