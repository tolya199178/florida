<?php

/**
 * User identity component to manage facebook authentication
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * FBIdentity represents the data needed to identity a Facebook user.
 * ...It contains the authentication method that checks if the provided
 * ...data can identity the user.
 *
 * ...The authenticate method connects to facebook and validates the
 * ...connection. The authentication details are for the application,
 * ...(API Key and API Secret), which is obtained from the config file.
 *
 * @package Components
 * @version 1.0
 */
class FBIdentity extends CUserIdentity
{

	//inherit username, password. Unuse here.
    /**
     *
     * @var int The internal Auth system id
     */
    public $_id;

    /**
     * Overrided parent method
     * @return type
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Authenticate user
     * @return type
     */
    public function authenticate()
    {

        // Load the facebook component
        // TODO: figure why component is not autoloading.
        $objFacebook  = Yii::app()->getComponent('facebook');

        // Establish a connection to facebook
        $objFacebook->connect();

        if ($objFacebook->isLoggedIn()) {
            // The user is logged in through facebook.

            $fbUserInfo = $objFacebook->getUserInfo();

            // /////////////////////////////////////////////////////////////////
            // Search for the user using both the email, and facebook id
            // /////////////////////////////////////////////////////////////////
            $dbCriteria = new CDbCriteria();
            $dbCriteria->condition = 'facebook_id=:facebook_id';
            $dbCriteria->addCondition('email=:email', 'OR');
            $dbCriteria->params = array(
                ':facebook_id' => $fbUserInfo['id'],
                ':email' => $fbUserInfo['email']
            );

            $modelUser = User::model()->find($dbCriteria);

            if ($modelUser === NULL) {

                // Save new facebook user to database
                $modelUser = new User();
                $modelUser->facebook_id = $fbUserInfo['id'];
                $modelUser->email = $fbUserInfo['email'];
                $modelUser->activation_status = 'activated';
                $modelUser->registered_with_fb = 'Y';
                $modelUser->facebook_name = $fbUserInfo['name'];
                $modelUser->first_name = $fbUserInfo['first_name'];
                $modelUser->last_name = $fbUserInfo['last_name'];
                $modelUser->user_type = 'user';
                $modelUser->status = 'active';

            } else {
                // //////////////////////////////////////////////////////////////
                // We need to determine the actual account status of the user and
                // ...modify the user details. A few scenarios could unfold :-
                // ...a)The user might match on the facebook id and email
                // ... This is a know user that is logging in again. No action.
                // ...b)The user might match on the facebook id only
                // ... This is an old user, with a new email address. We store
                // ... the user details
                // ...c)The user might match on an email address only.
                // ... This is an old (possibly legacy) user, who is now logging
                // ... in via facebook. We store the facebook id.
                // //////////////////////////////////////////////////////////////

                if (($modelUser->facebook_id == $fbUserInfo['id']) && ($modelUser->email == $fbUserInfo['email'])) { // The user matche on the facebook id and email. This is a
                  // ...know user that is logging in again
                  // ...Do nothing
                    ;
                } elseif (($modelUser->facebook_id == $fbUserInfo['id']) && ($modelUser->email != $fbUserInfo['email'])) {
                    // The user matches on the facebook id only. This is an old
                    // ...user, with a new email address. Store the user details
                    $modelUser->email = $fbUserInfo['email'];
                    $modelUser->user_name = $fbUserInfo['email'];
                } elseif (($modelUser->facebook_id != $fbUserInfo['id']) && ($modelUser->email == $fbUserInfo['email'])) {
                    // The user matches on an email address only. This is an old
                    // ...(possibly legacy) user, who is now logging in via
                    // ...facebook. We store the new/uddated facebook id.
                    $modelUser->facebook_id = $fbUserInfo['id'];
                }

            }

            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
            if ($modelUser->save(false))
            {
                $this->errorCode = self::ERROR_NONE;
                $this->_id       = $modelUser->user_id;
            }

        }
        else
        {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        }


	   return $this->errorCode;
    }

}