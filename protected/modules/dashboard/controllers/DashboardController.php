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

        switch ($argComponent)
        {
            case 'allfriends':
                $configDashboard['mainpanel'] = 'friends';
                break;
            case 'onlinefriends':
                $configDashboard['mainpanel'] = 'friends';
                break;
            case 'sentfriendrequests':
                $configDashboard['mainpanel'] = 'friends';
                break;
            case 'receivedfriendrequests':
                $configDashboard['mainpanel'] = 'friends';
                break;

            default:
                $configDashboard['mainpanel'] = 'default';
        }

        // /////////////////////////////////////////////////////////////////////
        // Get the user's businesses
        // /////////////////////////////////////////////////////////////////////

        $dbCriteria                         = new CDbCriteria();
        $dbCriteria->with                   = array('businessUsers');
        $dbCriteria->condition              = "businessUsers.user_id = :user_id";
        $dbCriteria->params                 = array(':user_id' => Yii::app()->user->id);

        $listMyBusiness = Business::model()->findAll($dbCriteria);

        // /////////////////////////////////////////////////////////////////////
        // Get a list of the user's friends
        // /////////////////////////////////////////////////////////////////////
        // /////////////////////////////////////////////////////////////////////
        // First, get a list of all local friends
        // /////////////////////////////////////////////////////////////////////
        $lstMyFriends   = MyFriend::model()
                            ->with('friend')
                            ->findAllByAttributes(array('user_id' => Yii::app()->user->id)
                          );

        // /////////////////////////////////////////////////////////////////////
        // Now, get a list of the user's facebook friends
        // /////////////////////////////////////////////////////////////////////
        // Load the component
        // TODO: figure why component is not autoloading.
        $objFacebook                        = Yii::app()->getComponent('facebook');

        // Establish a connection to facebook
        $objFacebook->connect();

        $lstMyOnlineFriends                 = array();
        if ($objFacebook->isLoggedIn())
        {
            $lstMyOnlineFriends = $objFacebook->getFriendList();
        }

        // /////////////////////////////////////////////////////////////////////
        // Get the user's messages
        // /////////////////////////////////////////////////////////////////////
        $listMessages   = UserMessage::model()->findAllByAttributes(array(
                            'recipient' => Yii::app()->user->id
                          ));

        // /////////////////////////////////////////////////////////////////////
        // Get a list of the user's images
        // /////////////////////////////////////////////////////////////////////
        $listPhotos = Photo::model()->findAllByAttributes(array(
                        'entity_id' => Yii::app()->user->id,
                        'photo_type' => 'user'
                    ));

        // /////////////////////////////////////////////////////////////////////
        // TODO: Get a list of the user's activities logs
        // /////////////////////////////////////////////////////////////////////
        // TODO:
        $listMyActivities                   = array(); // TODO:
        // TODO:

        // TODO: TODO: TODO:
        // THIS IS SAMPLE DATA
        $myFriendsCount['allfriends']               = 128;
        $myFriendsCount['onlinefriends']            = 13;
        $myFriendsCount['sentfriendrequests']       = 76;
        $myFriendsCount['receivedfriendrequests']   = 1;
        // TODO: TODO: TODO:
        // THIS IS SAMPLE DATA


        $configDashboard['data'] = array(
            'listMyBusiness' => $listMyBusiness,
            'myLocalFriends' => $lstMyFriends,
            'myOnlineFriends' => $lstMyOnlineFriends,
            'myMessages' => $listMessages,
            'myPhotos' => $listPhotos,
            'myActivities' => $listMyActivities,
            'myFriendsCount' => $myFriendsCount
        );

        // Show the dashboard
        $this->render('dashboard_main', array('configDashboard' => $configDashboard));
    }


}