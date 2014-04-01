<?php

/**
 * Component that extends CWebUser and retrieves the user information from database
 * ...tables.
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * This component class extends the CWebUser and provide override functions to
 * ...requests from Yii user management. We do this because the application is
 * ...customised to use a database as a repository for authentication data.
 *
 * @package Components
 * @version 1.0
 */


class WebUser extends CWebUser
{
    // Store model to not repeat query.
    private $_model;
    // Return first name.
    // access it by Yii::app()->user->first_name
    function getFirstName()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        return $userModel->first_name;
    }

    function getFullName()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        return $userModel->fullName();
    }

    function getRole()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        return $userModel->role;
    }

    function getPage()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        return $userModel->pagination;
    }

    function getPasswordExpires()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        return $userModel->checkExpiryDate();
    }

    // This is a function that checks the field 'role'
    // in the User model to be equal to constant defined in our User class
    // that means it's admin
    // access it by Yii::app()->user->isAdmin()
    function isAdmin()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        if ($userModel !== null)
        {
            return intval($userModel->user_type) == User::USER_TYPE_ADMIN;
       }
        else
        {
            return false;
        }
    }
    
    // This is a function that checks the field 'role'
    // in the User model to be equal to constant defined in our User class
    // that means it's admin
    // access it by Yii::app()->user->isAdmin()
    function isSuperAdmin()
    {
        $userModel = $this->loadUser(Yii::app()->user->id);
        if ($userModel !== null)
        {
            return $userModel->user_type == User::USER_TYPE_SUPERADMIN;
        }
        else
        {
            return false;
        }
    }

    
    // Load user model.
    protected function loadUser($userId = null)
    {
        if ($this->_model === null) {
            if ($userId !== null)
                $this->_model = User::model()->findByPk($userId);
        }
        return $this->_model;
    }
}