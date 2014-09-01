<?php

/**
 * PasswordForm class.
 * PasswordForm is the data structure for keeping
 * password recovery form data. It is used by the 'recovery' action of 'DefaultController'.
 */
class PasswordForm extends CFormModel
{

    /**
     *
     * @var _identity Internal variable used to identify user
     */
    private $_identity;

    /**
     *
     * @var User model
     */
    private $userModel;

    /**
     *
     * @var String request token for forgot password reset
     */
    public $request_token;

    /**
     * Various field values
     */
    public $user_id;

	public $user_name;
	public $email;

	public $password;
	public $new_password;
	public $confirm_new_password;



	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
         return array(
			array('password, new_password, confirm_new_password',    'required', 'on'=>'change_password'),
		    array('email',                                           'required', 'on'=>'forgot_password'),
            array('confirm_new_password',                            'compare',
                                                                     'on'=>'change_password',
                                                                     'compareAttribute'=>'new_password',
                                                                     'message'=>"Passwords don't match"),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'user_id'		        => Yii::t('UsrModule.usr','User Id'),
		    'user_name'		        => Yii::t('UsrModule.usr','User name'),
			'email'			        => Yii::t('UsrModule.usr','Email'),
	        'password'		        => Yii::t('UsrModule.usr','Your password'),
		    'new_password'		    => Yii::t('UsrModule.usr','Your New password'),
		    'confirm_new_password'	=> Yii::t('UsrModule.usr','Confirm your new password'),

		);
	}

    /**
     * Logs in the user using the given fldUserName and fldPassword in the model.
     *
     * @return boolean whether login is successful
     */
    public function login()
    {

        if (empty(Yii::app()->user->id) === null)
        {
            return false;
        }

        // /////////////////////////////////////////////////////////////////////
        // Don't allow users that are not active.
        // /////////////////////////////////////////////////////////////////////
        $userModel = User::model()->findByPk(Yii::app()->user->id);

        if ($userModel === null)        // Account not found
        {
            return false;
        }

        if ( ($userModel->attributes['activation_status'] == 'not_activated') ||
             ($userModel->attributes['status'] == 'inactive') )
        {
            return false;
        }

        $this->userModel    = $userModel;
        $this->email        = $userModel->attributes['user_name'];

        $this->_identity    = new UserIdentity(CHtml::encode($userModel->attributes['user_name']),
                                               CHtml::encode($this->password));

        $this->_identity->authenticate();

        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            return true;
        }
        else
        {
            $this->addError('password', "Your login details are not correct.");
            return false;
        }
    }


    /**
     * Changes the user's password
     */
    public function changePassword($userEmail = null)
    {

        if ($userEmail != null)
        {
            $this->userModel = User::model()->findByAttributes(array('user_name'=>$userEmail));
        }


        if ($this->userModel === null)        // Account not found
        {
            return false;
        }

        $this->userModel->scenario = User::SCENARIO_CHANGE_PASSWORD;

        $this->userModel->fldCurrentPassword    = $this->password;
        $this->userModel->password              = $this->new_password;
        $this->userModel->fldVerifyPassword     = $this->confirm_new_password;

        //return $this->userModel->save();
        $this->userModel->save();

    }

}
