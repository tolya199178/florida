<?php

/**
 * This is the model class for Login form
 *
 * The followings are the available columns in table '{{user_event}}':
 * @property string $fldUserName
 * @property string fldPassword
 *
 */
    
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping user login form data.    
 * It is used by the 'login' action of 'SiteController'.
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
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
    
    /**
     * Set rules for validation of model attributes. Each attribute is listed with its
     * ...associated rules. All attributes listed in the rules set forms a set of 'safe'
     * ...attributes that allow it to be used in massive assignment.
     *
     * @param <none> <none>
     *
     * @return array validation rules for model attributes.
     * @access public
     */
    public function rules()
    {
        return array(
            
            // fldUserName and fldPassword are required
            array(
                'fldUserName, fldPassword',
                'required',
                'message' => "{attribute} required"
            ),
            
            // Pradesh hack for offline testing for audit. Disable MX check
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
     * @param string $attribute the field being validated
     * @param array $params options specified in the validation rule
     * 
     * @return boolean result of validation
     */
    public function validateUserAccount($attribute,$params)
    {
        
        $sql = 'user_name=:user_name AND status=:status';
        $count = User::model()->count($sql, array(
            ':user_name' => $this->fldUserName,
            ':status' => 'active'
        ));
        
        if ($count == 0) {
            return false;
        }
        else {
            return true;
        }

    }

    /**
     * Label set for attributes. Only required for attributes that appear on view/forms.
     * ...
     * Usage:
     *    echo $form->label($model, $attribute)
     *
     * @param <none> <none>
     *
     * @return array customized attribute labels (name=>label)
     * @access public
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe' => 'Remember me.'
        );
    }

    /**
     * Custom validation to authenticates the user.
     * This is the 'authenticate' validator as declared in rules()
     *
     * @param string $attribute the field being validated
     * @param array $params options specified in the validation rule
     *
     * @return boolean result of validation
     */
    public function authenticate($attribute, $params)
    {
        if (! $this->hasErrors()) {
            $this->_identity = new UserIdentity($this->fldUserName, $this->fldPassword);
            if (! $this->_identity->authenticate())
                $this->addError($attribute, 'Incorrect fldUserName or password.');
        }
    }

    /**
     * Logs in the user using the given fldUserName and fldPassword in the model.
     * 
     * @return boolean whether login is successful
     */
    public function login()
    {
        
        // /////////////////////////////////////////////////////////////////////
        // Don't allow users that are not active.
        // /////////////////////////////////////////////////////////////////////
        $userModel = User::model()->find('LOWER(user_name)=?', array(
            strtolower(CHtml::encode($this->fldUserName))
        ));
        
        if ($userModel === null)        // Account not found
        {
            return false;
        }
        
        if ( ($userModel->attributes['activation_status'] == 'not_activated') || ($userModel->attributes['status'] == 'inactive') )
        {
            return false;   
        }
        
        
        
        
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity(CHtml::encode($this->fldUserName), CHtml::encode($this->fldPassword));
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->fldRememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
        {
            return false;
        }
    }
}