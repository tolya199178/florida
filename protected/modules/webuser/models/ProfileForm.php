<?php

/**
 * ProfileForm class.
 * ProfileForm is the data structure for keeping
 * password recovery form data. It is used by the 'recovery' action of 'DefaultController'.
 */
class ProfileForm extends CFormModel
{

    /**
     * Various field values
     */
    public $user_id;
    public $fldVerifyPassword;
    public $date_of_birth;
    public $mobile_carrier_id;
    public $mobile_number;
    public $hometown;
    public $marital_status;
    public $send_sms_notification;
    public $my_info_permissions;
    public $photos_permissions;
    public $friends_permissions;
    public $blogs_permissions;
    public $travel_options_permissions;


	public $user_name;
	public $email;
	public $first_name;
	public $last_name;
	public $picture;
	public $removePicture;
	public $password;
	public $confirm_password;
	public $places_want_to_visit;
	public $places_visited;
	public $language;
	public $image;


	/**
	 * @var verifyCode Capctha security mechanism to prevent automated submission of form
	 */
	public $verifyCode;

	/**
	 * @var IdentityInterface cached object returned by @see getIdentity()
	 */
	private $_identity;

	/**
	 * @var array Picture upload validation rules.
	 */
	private $_pictureUploadRules;

	/**
	 *
	 * @var string fldUploadImage User image uploader.
	 * @access public
	 */
	public $fldUploadImage;

	/**
	 *
	 * @var string fldUploadImage User image uploader.
	 * @access public
	 */
	public $fldUploadMyGalleryImage;

	/**
	 * @var string imagesDirPath Directory where User images will be stored
	 * @access private
	 */
	private $imagesDirPath;

	/**
	 * @var string imagesDirPath Directory where User image thumbnails will be stored
	 * @access private
	 */
	private $thumbnailsDirPath;

	/**
	 * @var string thumbnailWidth thumbnail width
	 * @access private
	 */
	private $thumbnailWidth     = 100;
	/**
	 * @var string thumbnailWidth thumbnail width
	 * @access private
	 */
	private $thumbnailHeight    = 100;

	/**
	 * Controller initailisation routines to set up the controller
	 *
	 * @param <none> <none>
	 *
	 * @return array action filters
	 * @access public
	 */
	public function init()
	{
	    $this->imagesDirPath        = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/user';
	    $this->thumbnailsDirPath    = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'/uploads/images/user/thumbnails';

	    /*
	     *     Small-s- 100px(width)
	    *     Medum-m- 240px(width)
	    *     Large-l- 600px(width)
	    */
	}


	/**
	 * Returns rules for picture upload or an empty array if they are not set.
	 * @return array
	 */
	public function getPictureUploadRules()
	{
		return $this->_pictureUploadRules === null ? array() : $this->_pictureUploadRules;
	}

	/**
	 * Sets rules to validate uploaded picture. Rules should NOT contain attribute name as this method adds it.
	 * @param array $rules
	 */
	public function setPictureUploadRules($rules)
	{
		$this->_pictureUploadRules = array();
		if (!is_array($rules))
			return;
		foreach($rules as $rule) {
			$this->_pictureUploadRules[] = array_merge(array('picture'), $rule);
		}
	}

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
         return array(
        			array('user_name, email, first_name, last_name, removePicture', 'filter', 'filter'=>'trim'),
        			array('user_name, email, first_name, last_name, removePicture', 'default', 'setOnEmpty'=>true, 'value' => null),

        			array('email, first_name, last_name', 'required'),
        			array('email', 'uniqueIdentity'),
        			array('email', 'email'),
        			array('removePicture', 'boolean'),
        			array('password', 'validCurrentPassword', 'except'=>'register'),
                    array('confirm_password', 'validCurrentPassword', 'except'=>'register'),

                    // mobile carrier is mandatory if mobile number is entered, and vice-versa, and if
                    // ...the send SMS notification flag is set, then both mobile carrier  and mobile
                    // ...number values are mandatory.
                    array('mobile_number, mobile_carrier_id, send_sms_notification', 'validateMobileFields'),

                    array('date_of_birth',                  'validateAge', 'age_limit' => 18),

                    array('language',                       'length', 'max'=>255),

                    array('fldUploadImage',                 'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),
                    array('fldUploadMyGalleryImage',        'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),




                    array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on'=>'register'),

        		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'user_name'		=> Yii::t('UsrModule.usr','Username'),
			'email'			=> Yii::t('UsrModule.usr','Email'),
			'first_name'	=> Yii::t('UsrModule.usr','First name'),
			'last_name'		=> Yii::t('UsrModule.usr','Last name'),
			'picture'		=> Yii::t('UsrModule.usr','Profile picture'),
			'removePicture'	=> Yii::t('UsrModule.usr','Remove picture'),
			'password'		=> Yii::t('UsrModule.usr','Your password'),
		    'confirm_password'		=> Yii::t('UsrModule.usr','Confirm password'),
		    'verifyCode'    => Yii::t('UsrModule.usr','Verification Code'),
		    'date_of_birth' => Yii::t('UsrModule.usr','Date of Birth'),
		    'language'      => Yii::t('UsrModule.usr','Language'),

		);
	}

	/**
	 * @inheritdoc
	 */
	public function getIdentity()
	{
// 		if($this->_identity===null) {
// 			$userIdentityClass = $this->userIdentityClass;
// 			if ($this->scenario == 'register') {
// 				$this->_identity = new $userIdentityClass(null, null);
// 			} else {
// 				$this->_identity = $userIdentityClass::find(array('id'=>Yii::app()->user->getId()));
// 			}
// 			if ($this->_identity !== null && !($this->_identity instanceof IEditableIdentity)) {
// 				throw new CException(Yii::t('UsrModule.usr','The {class} class must implement the {interface} interface.',array('{class}'=>get_class($this->_identity),'{interface}'=>'IEditableIdentity')));
// 			}
// 		}
// 		return $this->_identity;
	}

	public function setIdentity($identity)
	{
// 		$this->_identity = $identity;
	}

	public function uniqueIdentity($attribute,$params)
	{
		if($this->hasErrors()) {
			return;
		}
// 		$userIdentityClass = $this->userIdentityClass;
// 		$existingIdentity = $userIdentityClass::find(array($attribute => $this->$attribute));
// 		if ($existingIdentity !== null && (($identity=$this->getIdentity()) !== null && $existingIdentity->getId() != $identity->getId())) {
// 			$this->addError($attribute,Yii::t('UsrModule.usr','{attribute} has already been used by another user.', array('{attribute}'=>$this->$attribute)));
// 			return false;
// 		}
		return true;
	}

	/**
	 * A valid current password is required only when changing email.
	 */
	public function validCurrentPassword($attribute,$params)
	{
		if($this->hasErrors()) {
			return;
		}
// 		if (($identity=$this->getIdentity()) === null) {
// 			throw new CException('Current user has not been found in the database.');
// 		}
// 		if ($identity->getEmail() === $this->email) {
// 			return true;
// 		}
// 		$identity->password = $this->$attribute;
// 		if(!$identity->authenticate()) {
// 			$this->addError($attribute, Yii::t('UsrModule.usr', 'Changing email address requires providing the current password.'));
// 			return false;
// 		}
		return true;
	}

	/**
	 * Logs in the user using the given user_name.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
// 		$identity = $this->getIdentity();

// 		return Yii::app()->user->login($identity,0);
	}

	/**
	 * Updates the identity with this models attributes and saves it.
	 * @param CUserIdentity $identity
	 * @return boolean whether saving is successful
	 */
	public function save()
	{
// 		if (($identity=$this->getIdentity()) === null)
// 			return false;

// 		$identity->setAttributes($this->getAttributes());
// 		if ($identity->save(Yii::app()->controller->module->requireVerifiedEmail)) {
// 			if ((!($this->picture instanceof CUploadedFile) || $identity->savePicture($this->picture)) && (!$this->removePicture || $identity->removePicture())) {
// 				$this->_identity = $identity;
// 				return true;
// 			}
// 		}
		return false;
	}

	/**
	 * Custom validation for fields mobile_number, mobile_carrier_id,
	 * send_sms_notification.
	 *
	 * mobile carrier is mandatory if mobile number is entered, and vice-versa,
	 * ...and if the send SMS notification flag is set, then both mobile
	 * ...carrier, and mobile number values are mandatory.
	 *
	 * @param string $attribute the attribute being validated
	 * @return array $params optional additional parameters defined in the rule.
	 */
	public function validateMobileFields($attribute, $params)
	{
	    if ($this->send_sms_notification == 'Y')
	    {
            if (empty($this->mobile_number))
            {
                $this->addError('mobile_number', 'You must supply a mobile number.');
            }
            if (empty($this->mobile_carrier_id))
            {
                $this->addError('mobile_carrier_id', 'You must specify a mobile carrier.');
            }
	    }
	    else
	    {
	        if (!empty($this->mobile_number) && empty($this->mobile_carrier_id))
	        {
	            $this->addError('mobile_carrier_id', 'You must specify a mobile carrier.');
	        }
	        if (!empty($this->mobile_carrier_id) && empty($this->mobile_number))
	        {
	            $this->addError('mobile_number', 'You must supply a mobile number.');
	        }
	    }


	}

	/**
	 * Validate the user's age is greater than the supplied limit
	 *
	 * @param string $attribute the attribute being validated
	 * @return array $params optional additional parameters defined in the rule.
	 */
	public function validateAge($attribute, $params)
	{

	    $dateBirth  = strtotime($this->$attribute);

	    $ageDateLimit   = strtotime('+'.$params['age_limit'].' years', $dateBirth);


	    if(time() < $ageDateLimit)  {
	        $this->addError($attribute, 'Registered users must be older than '.$params['age_limit'].' .');
	    }

	}


}
