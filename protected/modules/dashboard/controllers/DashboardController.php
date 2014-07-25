<?php

/**
 * Dashboard Controller interface for the Frontend (Public) Dashboards Module
 */


/**
 * DashboardController is a class to provide access to controller actions for the
 * ...user dashboard (front-end). The controller action interfaces directly' with
 * ...the Client, and must therefore be responsible for input processing and
 * ...response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/dashboard/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/dashboard/profile/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /dashboard/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /dashboard/profile/show/name/toms/ will pass $_GET['name'] = 'toms'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class DashboardController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * Default controller action.
     * Displays the dashboard by forwarding to the dashboard render action
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{

	    $this->redirect(Yii::app()->createUrl('/dashboard/dashboard/show/'));

	}

    /**
     * Displays the dashboard
     *
     * @param
     *            <none> <none>
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
        $userModel                            = User::model()->findByPk($userId);
        if ($userModel === null)
        {
            $this->redirect("login");
        }

        $configDashboard['leftpanel']         = 'left_panel';

        /*
         * Get the main dashboard component
         */
        $argComponent = Yii::app()->request->getQuery('component', 'default');

        $listMyBusiness = array();
        $listMessages = array();
        $listPhotos = array();
        $listMyActivities = array();
        $myFriendsCount = array();

        $configDashboard['mainpanel'] = 'default';

        // /////////////////////////////////////////////////////////////////////
        // Get the user's businesses
        // /////////////////////////////////////////////////////////////////////

        $dbCriteria                         = new CDbCriteria();
        $dbCriteria->with                   = array('businessUsers');
        $dbCriteria->condition              = "businessUsers.user_id = :user_id";
        $dbCriteria->params                 = array(':user_id' => Yii::app()->user->id);

        $listMyBusiness = Business::model()->findAll($dbCriteria);


        // /////////////////////////////////////////////////////////////////////
        // Get the user's messages
        // /////////////////////////////////////////////////////////////////////

        /*
         * Get the message summary details
         */

        $countNewMessages = Yii::app()->db->createCommand()
                                          ->select('COUNT(*) AS count')
                                          ->from('tbl_user_message')
                                          ->where('recipient = :user_id AND `read` = "N"',
                                                  array('user_id' => Yii::app()->user->id))
                                          ->queryRow();

        $myMessagesCount['countUnreadMessages'] = $countNewMessages['count'];

        $listMyMessages   = UserMessage::model()->findAllByAttributes(array(
                                'recipient' => Yii::app()->user->id
                            ));

        // /////////////////////////////////////////////////////////////////////
        // Get a list of the user's images
        // /////////////////////////////////////////////////////////////////////
        $listImages = Photo::model()->findAllByAttributes(array(
                        'entity_id' => Yii::app()->user->id,
                        'photo_type' => 'user'
                      ));

        // /////////////////////////////////////////////////////////////////////
        // Get a list of the user's events
        // /////////////////////////////////////////////////////////////////////
        $listEvents = Event::model()->findAllByAttributes(array(
                                        'user_id' => Yii::app()->user->id,
                                      ));

        // /////////////////////////////////////////////////////////////////////
        // Get a list of the user's saved searches
        // /////////////////////////////////////////////////////////////////////
        $mySavedSearch = Yii::app()->db->createCommand()
                                       ->select("*")
                                       ->from('tbl_saved_search')
                                       ->where('user_id = :user_id', array(':user_id' => Yii::app()->user->id))
                                       ->queryAll();

        // /////////////////////////////////////////////////////////////////////
        // TODO: Get a list of the user's activities logs
        // /////////////////////////////////////////////////////////////////////
        // TODO:
        $listMyActivities                   = array(); // TODO:
        // TODO:


        $resultsFriendSummary = MyFriend::FriendSummary(Yii::app()->user->id);
        $userFriendSummary = array_pop($resultsFriendSummary);

        $myFriendsCount['allfriends']               = $userFriendSummary['approved'];
        $myFriendsCount['onlinefriends']            = 0;
        $myFriendsCount['sentfriendrequests']       = $userFriendSummary['pending'];
        $myFriendsCount['receivedfriendrequests']   = count(MyFriend::model()
                                                            ->findAllByAttributes(
                                                                array('friend_id'    => Yii::app()->user->id,
                                                                      'friend_status'=> 'pending'
                                                                )
                                                              )
                                                      );


        $configDashboard['data'] = array(
            'listMyBusiness'    => $listMyBusiness,
            'listMyMessages'    => $listMyMessages,
            'listEvents'        => $listEvents,
            'myPhotos'          => $listPhotos,
            'myActivities'      => $listMyActivities,
            'myFriendsCount'    => $myFriendsCount,
            'myMessagesCount'   => $myMessagesCount,
            'mySavedSearch'     => $mySavedSearch,
            'component'         => $argComponent
        );

        // Show the dashboard
        $this->render('dashboard_main', array('configDashboard' => $configDashboard));
    }



}