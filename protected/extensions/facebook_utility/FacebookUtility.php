<?php
/*
* Facebook Toolbox component
*
*/

/**
 * Facebook Toolbox
 *
 * A helper class for facebook application development. Very handy for
 * performing common facebook activities like:
 *
 * - Getting users profile information,
 * - Getting friend list,
 * - Getting application to user profile,
 * - Sending email notification message
 * - Sending Notification Message
 * - Publishing news feed or story to user profile.
 *
 * @author      Pradesh Chanderpaul <pradesh@datacraft.co.za>
 * @package     FacebookUtility
 * @copyright   2014 Florida.com
 * @link        http://www.florida.com
 * @since       Version 1.0
 */

// Include facebook client library
// require_once __DIR__ . '/../facebook-php-sdk/src/base_facebook.php';
require_once __DIR__ . '/../facebook-php-sdk/src/facebook.php';

class FacebookUtility extends CApplicationComponent
{


    /*
     * Holds the facebook object
    *
    * @var Object
    */
    private $handleFacebook;

    /**
     * Facebook user id
     *
     * @var integer
     */
    private $fbuser;

    /**
     * Facebook generated id
     *
     * @var integer
     */

    private $fbGeneratedUserId;

    /**
     * Facebook API key
     *
     * @var string
     */
    public $apiKey;

    /**
     * Facebook secret key
     *
     * @var string
     */
    public $secretKey;

    /**
     * URL for application login
     *
     * @var string
     */
    public $loginURL;

    /**
     * URL for application logout
     *
     * @var string
     */
    public $logoutURL;

    /**
     * List of profile information retrieved from Facebook
     *
     * @var array
     */
    public $userProfile;


  /**
   * Initialize a component
   *
   * The configuration details are automagically loaded from the config file:
   * - apiKey: the application ID
   * - secretKey: the application secret
   *
   * @param array $config The application configuration
   */
	public function init()
	{
		parent::init();

	}

	/**
	 * Establish a connection with the provider
	 *
	 * The configuration keys are passed to the API layer and a connection
	 * ...is made to the provider. On successful connection, some configuration
	 * ...values are retrieved for future use.
	 *
	 * @param array $config The application configuration
	 */
	public function connect()
	{
	    // The apiKey and secretKey are automagically loaded from the config file.
        $facebookConfig = array(
            'appId'     => $this->apiKey,
            'secret'    => $this->secretKey
        );


        $this->handleFacebook = new Facebook($facebookConfig);

        // Get User ID
        $this->fbGeneratedUserId = $this->handleFacebook->getUser();

        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.

        if ($this->fbGeneratedUserId) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $this->userProfile = $this->handleFacebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $this->fbGeneratedUserId = null;
            }
        }

        // Login or logout url will be needed depending on current user state.
        if ($this->fbGeneratedUserId) {
            $this->logoutURL = $this->handleFacebook->getLogoutUrl();
        } else {
            // $this->statusUrl = $this->handleFacebook->getLoginStatusUrl();

            $this->loginURL = $this->handleFacebook->getLoginUrl(array(
                                'scope' => 'email,publish_stream,status_update,user_birthday,user_location,user_work_history'
                              ));
            $this->logoutURL = $this->handleFacebook->getLogoutUrl();
        }
	}

	/**
	 * Retrieve the URL to direct login requests to.
	 *
	 * @param <none> <none>
	 */
	public function getLoginUrl()
	{
	    if (!$this->isLoggedIn())
	    {
	        return $this->loginURL;
	    }
	    else
	    {
	        return '';
	    }

	}

	/**
	 * Retrieve the URL to direct logout requests to.
	 *
	 * @param <none> <none>
	 */
	public function getLogoutUrl()
	{
	    if ($this->isLoggedIn())
	    {
	        return $this->logoutURL;
	    }
	    else
	    {
	        return '';
	    }

	}

	/**
	 * Force a logout
	 *
	 * @param <none> <none>
	 */
	public function logout()
	{
        $token = $this->handleFacebook->getAccessToken();
        $url = 'https://www.facebook.com/logout.php?next='.'http://dev.florida.com/'.'&access_token='.$token;
        session_destroy();
        header('Location: '.$url);

	}


	/**
	 * Checks if a user is currently logged  in
	 *
	 * @param <none> <none>
	 * @return string UserId The provider user id
	 */
	public function isLoggedIn()
	{
        return $this->fbGeneratedUserId;
	}


	/**
	 * Returns the provider user id of the currently logged in user.
	 *
	 * @param <none> <none>
	 * @return string UserId The facebook user id
	 */
	public function getUserId()
	{
	    return $this->fbGeneratedUserId;
	}


    /**
     * Get User Info
     *
     * Retrieves the varous profile information for a given user. You can
     * provide the list of fields to retrieve. When nothing is specified,
     * it will fetch the basic ones.
     *
     * @param int facebook user id
     * @param string field list (optional)
     * @return array profile fields
     *
     */
    public function getUserInfo()
    {
        return $this->userProfile;
    }


    /**
     * Get Friend List
     *
     * This function will retrieve the friend list of any given facebook
     * user id. Optionally, it allows a few parameters to customize the
     * list.
     *
     * @param int facebook user id
     * @param bool whether the friends have installed this application
     * @param int start limit
     * @param int total limit
     * @return array friend list
     *
     */
    public function getFriendList(/* $fbuserId, $appUser = false, $start = 0, $limit = 20 */)
    {

        try {

            $userProfile = $this->handleFacebook->api('/me');

            $userFriends = $this->handleFacebook->api('/me/friends',
                                  array('fields' => 'name, id, first_name, last_name, email'));

            $accessToken = $this->handleFacebook->getAccessToken();

        } catch (FacebookApiException $e) {
             print_r($e);
            $user = null;

        }

// print_r($userFriends);exit;
//         $token = $this->handleFacebook->getAccessToken();
//         foreach ($userFriends["data"] as $value) {

//             $uid = $value["id"];

//             // get all friends who has given our app permissions to access their data
//             $fql = "SELECT uid, first_name, last_name, email FROM user WHERE uid = $uid";

//             $friendDetails = $this->handleFacebook->api(array(
//                                         'method'       => 'fql.query',
//                                         'access_token' => $token,
//                                         'query'        => $fql,
//                                     ));
//         }

        return $userFriends['data'];

    }

    /**
     * Add To Profile
     *
     * This function adds the application to specified user's profile.
     *
     * @param int facebook user id
     * @param string path to the screenshot or fbml of wider profile fbml which will add at box profile
     * @param string path to the screenshot or fbml of narrow profile fbml which will add at home page
     * @return void
     *
     */
    public function addToProfile($fbuserId, $wideprofileFbml, $narrowprofileFbml)
    {
        $this->fbuser = $fbuserId;
        $wide_handler = 'wide_handler_'.$this->fbuser;
        $narrow_handler = 'narrow_handler_'.$this->fbuser;
        $this->handleFacebook->api_client->call_method('facebook.Fbml.setRefHandle', array('handle' => $wide_handler,
                                                                                     'fbml'   => $wideprofileFbml));

        $this->handleFacebook->api_client->call_method('facebook.Fbml.setRefHandle', array('handle' => $narrow_handler,
                                                                                     'fbml'   => $narrowprofileFbml));

        $this->handleFacebook->api_client->call_method('facebook.profile.setFBML',   array('uid'          => $this->fbuser,
                                                                                     'profile'      => '<fb:wide><fb:ref handle="'.$wide_handler.'" /></fb:wide>
                                                                                                        <fb:narrow><fb:ref handle="'.$narrow_handler.'" /></fb:narrow>',
                                                                                     'profile_main' => '<fb:ref handle="'.$narrow_handler.'" />'));
    }

    /**
     * Send Notification
     *
     * This function sends notification to the specified users.
     *
     * @param array    facebook user ids
     * @param string notification message
     * @param string notification type. can be user_to_user OR app_to_user
     * @return void
     *
     */
    public function sendNotification($ids, $msg, $notificationType = 'app_to_user')
    {
        $this->handleFacebook->api_client->notifications_send($ids, $msg, $notificationType);
    }


    /**
     * Send Notification Email
     *
     * This function sends notification email to the specified users.
     *
     * @param string comma seprated facebook user ids
     * @param string subject of notification email
     * @param string notification message
     * @return void
     *
     */
    public function sendEmail($ids, $subject, $msg)
    {
        $this->handleFacebook->api_client->notifications_sendEmail($ids, $subject, "", $msg);
    }

    /**
     * Publish News Feed
     *
     * This function will publish news feed to the specified user profile.
     *
     * @param int facebook user id
     * @param int template bundle id
     * @return void
     *
     */
    public function publishNewsFeed($fbuserID,$templateBundleId)
    {
        $this->fbuser = $fbuserID;

        $tokens  = array();
        $friends = $this->getFriendList($this->fbuser, true);
        $targets = implode(',', $friends);
        try {
            $this->handleFacebook->api_client->feed_publishUserAction($templateBundleId, json_encode($tokens), $targets,'',3);
        }
        catch (Exception $ex) {
            //exception message
        }
    }
    /**
     * get template bundle id
     *
     * This function will get template bundle to register one story
     *
     * @param string one line story template
     * @return int template bundle id
     *
     */

    public function getTemplateBundleId($one_line_story_templates)
    {
        return $this->handleFacebook->api_client->feed_registerTemplateBundle($one_line_story_templates);
    }

}