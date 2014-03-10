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
     * local variables used to reference authenticaton values.
     * The current login values are retuned 
     * 
     * @return boolean whether authentication succeeds.
     *        
     */
    private $_userId;
    private $__userName;
    

    public function getName()
    {
        return $this->__userName;
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
        return $this->_userId;
    }

    public function authenticate()
    {

        $userModel = User::model()->find('LOWER(user_name)=?', array(
            strtolower($this->username)
        ));
        
        if ($userModel === null)
        {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        }
        else if($userModel->password !=  utf8_encode( crypt($userModel->user_name.$userModel->password,$userModel->password)))
        {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
        else
        {
            
            $userModel->scenario = User::SCENARIO_LOGIN;
            
            // Map the CUserIdentity user id field with the database user id field
            $this->_userId          = $userModel->user_id;
            
            $this->__userName       = $userModel->email;
                        
            $userModel->last_login  = new CDbExpression("NOW()");
            $userModel->save();
            $this->errorCode = self::ERROR_NONE;
        }
        return (!$this->errorCode);
    }
} 