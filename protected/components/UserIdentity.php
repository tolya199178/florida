<?php

/**
 * User identity component to manage authentication
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * UserIdentity represents the data needed to identity a user.
 * ...It contains the authentication method that checks if the provided
 * ...data can identity the user.
 *
 * @package Components
 * @version 1.0
 */
class UserIdentity extends CUserIdentity
{

    /**
     * Authenticates a user.
     * Authenticate against our Database
     * 
     * @return boolean whether authentication succeeds.
     *        
     */
    private $_id;

    private $_username;

    public function getName()
    {
        return $this->_username;
    }

    /**
     * Authenticates a user.
     * Authenticate against our Database
     *
     * @return boolean whether authentication succeeds.
     *
     */
    public function getId()
    {
        return $this->_id;
    }

    public function authenticate()
    {

//         $user = Users::model()->find('LOWER(username)=?', array(
//             strtolower($this->username)
//         ));
        $user = User::model()->find('LOWER(user_name)=?', array(
            strtolower($this->username)
        ));
        
        if ($user === null) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        }
        else if($user->password !==  utf8_encode( crypt($user->user_name.$user->password,$user->password))){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            // Map the CUserIdentity user id field with the database user id field
            $this->_id = $user->user_id;
            
            $this->_username = $user->email;
            
            $user->last_login = new CDbExpression("NOW()");
            $user->save();
            $this->errorCode = self::ERROR_NONE;
        }
        return ! $this->errorCode;
    }
} 