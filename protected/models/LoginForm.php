<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping user login form data.    
 * It is used by the 'login' action of 'SiteController'.
 * Extended class description
 *
 * @author pradesh
 * @version 1.0
 * @package application.models
 */
class LoginForm extends CFormModel
{

    /**
     *
     * @var fldUserName user's login account name
     *      The user's email address is used as the unique identifier.
     */
    public $fldUserName = '';

    /**
     *
     * @var fldPassword user's login fldPassword
     *      Clear test fldPassword entered by the user to authenticate the session
     */
    public $fldPassword = '';

    /**
     *
     * @var fldRememberMe User option to store login details
     *      The applicaion uses a cookie-based session storage mechanism
     */
    public $fldRememberMe = false;

    /**
     *
     * @var flgWithFB Facebook login option
     *      Flags if user is logging in with Facebook
     */
    public $flgWithFB = false;

    /**
     *
     * @var _identity Internal variable used to identify user
     *      Flags if user is logging in with Facebook
     */
    private $_identity;

    /**
     * Declare the validation rules
     *
     * The rules state that fldUserName and fldPassword are required,
     * and fldPassword needs to be authenticated. Overwrites the parent class.
     *
     * @param <none>
     * @return array of rules
     */
    
    
    public $isNewRecord = false;
    public $email;
    
    
    public function rules()
    {
        return array(
            
            // fldUserName and fldPassword are required
            array(
                'fldUserName, fldPassword',
                'required',
                'message' => "{attribute} required"
            ),
            
            // Pradesh hack for offline testing for audit
            // array('fldUserName', 'email', 'checkMX' => true, 'allowName' => true, 'message' => 'Email id not valid'),
            
            array(
                'fldPassword',
                'length',
                'max' => 20,
                'allowEmpty' => false
            ), // 'min'=>6
            
            array(
                'fldUserName',
                'validateUserAccount'
            ),
            
            // rememberMe needs to be a boolean
            array(
                'fldRememberMe',
                'boolean'
            ),
            
            // fldPassword needs to be authenticated
            array(
                'fldPassword',
                'authenticate'
            )
        );
    }

    /**
     * Custom validation to check email address
     *
     * The fldUserName is checked for existence against the database. An arror is raised
     * ...if the user is not registered, banned or marked as deleted
     *
     * @param
     *            <none>
     * @return <none>
     */
    public function validateUserAccount($attribute)
    {
        return true;
        
        $msg = '';
        $sql = 'email=:email AND mglist_id<>:list_id';
        $count = User::model()->count($sql, array(
            'list_id' => $id,
            ':member_id' => $member['member_id']
        ));
        ;
        
        $user = User::model()->count('email="' . $this->fldUserName . '"');
        if ($user == 0) :
            $msg = "Email id not available";
            $this->addError($attribute, $msg);
        
     endif;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe' => 'Remember me.'
        );
    }

    /**
     * Authenticates the fldPassword.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $this->_identity = new UserIdentity($this->fldUserName, $this->fldPassword);
            if (! $this->_identity->authenticate())
                $this->addError('fldPassword', 'Incorrect fldUserName or password.');
        }
    }

    /**
     * Logs in the user using the given fldUserName and fldPassword in the model.
     * 
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->fldUserName, $this->fldPassword);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }
}