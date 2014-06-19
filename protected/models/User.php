<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $user_id
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $user_type
 * @property string $status
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $activation_code
 * @property string $activation_status
 * @property string $activation_time
 * @property string $facebook_id
 * @property string $facebook_name
 * @property string $registered_with_fb
 * @property string $loggedin_with_fb
 * @property string $login_status
 * @property string $last_login
 * @property string $mobile_number
 * @property integer $mobile_carrier_id
 * @property string $send_sms_notification
 * @property string $date_of_birth
 * @property string $hometown
 * @property string $marital_status
 * @property string $places_want_to_visit
 * @property string $my_info_permissions
 * @property string $photos_permissions
 * @property string $friends_permissions
 * @property string $blogs_permissions
 * @property string $travel_options_permissions
 * @property string $image
 * @property string $places_visited
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property User[] $users
 * @property User $createdBy
 * @property User[] $users1
 * @property Advertisement[] $advertisements
 * @property Advertisement[] $advertisements1
 * @property Advertisement[] $advertisements2
 * @property Business[] $businesses
 * @property Business[] $businesses1
 * @property Business[] $businesses2
 * @property Business[] $businesses3
 * @property BusinessUser[] $businessUsers
 * @property Event[] $events
 * @property Event[] $events1
 * @property MailTemplate[] $mailTemplates
 * @property MailTemplate[] $mailTemplates1
 * @property Page[] $pages
 * @property Page[] $pages1
 * @property PlacesSubscribed[] $placesSubscribeds
 * @property PlacesVisited[] $placesVisiteds
 * @property SavedSearch[] $savedSearches
 * @property UserEvent[] $userEvents
 * @property SubscribedBusiness[] $subscribedBusinesses
 * @property BusinessRating[] $businessRatings
 *
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $user = User::model()
 * ...or
 * ...   $user = new User;
 * ...or
 * ...   $user = new User($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class User extends CActiveRecord
{

    // /////////////////////////////////////////////////////////////////////////
    // Scenario constants
    // /////////////////////////////////////////////////////////////////////////
    const SCENARIO_REGISTER         = 'register';
    const SCENARIO_CHANGE_PASSWORD  = 'change-password';
    const SCENARIO_FORGOT_PASSWORD  = 'forgot-password';
    const SCENARIO_LOGIN            = 'login';
    const SCENARIO_VALIDATION       = 'validation';

    const USER_TYPE_SUPERADMIN      = 'superadmin';
    const USER_TYPE_ADMIN           = 'admin';
    const USER_TYPE_BUSINESS        = 'business_user';
    const USER_TYPE_USER            = 'user';



    // /////////////////////////////////////////////////////////////////////////
    // Attributes to be used for form processing only
    // /////////////////////////////////////////////////////////////////////////

    /**
     * Form only. Used to hold the current password for change password screnario.
     * ...In this case the 'password' field will hold the new password.
     *
     * @param <none> <none>
     *
     * @return string the repeated password entry
     * @access public
     */
    public $fldCurrentPassword;

    /**
     * Form only. Used to verify the password entered.
     *
     * @param <none> <none>
     *
     * @return string the repeated password entry
     * @access public
     */
    public $fldVerifyPassword;

    /**
     *
     * @var string fldUploadImage User image uploader.
     * @access public
     */
    public $fldUploadImage;


    /**
     * Get database table name associated with the model.
     *
     * @param <none> <none>
     *
     * @return string the associated database table name
     * @access public
     */
    public function tableName()
    {
        return '{{user}}';
    }


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
        // NOTE: you should only define rules for those attributes that will receive user inputs.
        return array(

            // Mandatory rules
            array('user_name, email, first_name,
                   last_name',   'required', 'on' => array(self::SCENARIO_REGISTER)),
            array('password, user_name',            'required', 'on' => array(self::SCENARIO_LOGIN,self::SCENARIO_REGISTER)),
            array('password, fldVerifyPassword',    'required', 'on' => array(self::SCENARIO_REGISTER)),
            array('password, fldVerifyPassword,
                   fldCurrentPassword',             'required', 'on' => array(self::SCENARIO_CHANGE_PASSWORD)),

            array('activation_code',                'required', 'on' => self::SCENARIO_VALIDATION),
            array('email',                          'required', 'on' => self::SCENARIO_FORGOT_PASSWORD),

            // Data types, sizes
            array('mobile_carrier_id',              'numerical', 'integerOnly'=>true),
            array('user_name, email, password,
                   first_name, last_name,
                   activation_code, facebook_id,
                   facebook_name, hometown',        'length', 'max'=>255),
            array('places_want_to_visit,
                   places_visited',                 'length', 'max'=>4096),

            array('mobile_number',                  'length', 'max'=>64),

            // mobile carrier is mandatory if mobile number is entered, and vice-versa, and if
            // ...the send SMS notification flag is set, then both mobile carrier  and mobile
            // ...number values are mandatory.
            array('mobile_number, mobile_carrier_id, send_sms_notification', 'validateMobileFields'),

            array('email, user_name',               'email', 'checkMX'=>false),

            array('email', 'unique',                'on' => array(self::SCENARIO_REGISTER)),
            array('user_name', 'unique',            'on' => array(self::SCENARIO_REGISTER)),

            // Form only attributes.
            array('fldUploadImage',                       'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),



            // ranges
            array('user_type',                      'in','range'=>array('superadmin','admin','user','business_user'),'allowEmpty'=>false),
            array('status',                         'in','range'=>array('inactive','active','deleted','banned'),'allowEmpty'=>false),
            array('activation_status',              'in','range'=>array('activated','not_activated'),'allowEmpty'=>false),
            array('login_status',                   'in','range'=>array('logged in','logged out'),'allowEmpty'=>false),
            array('send_sms_notification',          'in','range'=>array('Y','N'),'allowEmpty'=>false),

            array('registered_with_fb',             'in','range'=>array('Y','N'),'allowEmpty'=>false),
            array('loggedin_with_fb',               'in','range'=>array('Y','N'),'allowEmpty'=>false),

            array('marital_status',                 'in','range'=>array('Married','Single','Unknown'),'allowEmpty'=>true),
            array('my_info_permissions',            'in','range'=>array('none','friends','all'),'allowEmpty'=>false),
            array('photos_permissions',             'in','range'=>array('none','friends','all'),'allowEmpty'=>false),
            array('friends_permissions',            'in','range'=>array('none','friends','all'),'allowEmpty'=>false),
            array('blogs_permissions',              'in','range'=>array('none','friends','all'),'allowEmpty'=>false),
            array('travel_options_permissions',     'in','range'=>array('none','friends','all'),'allowEmpty'=>false),

            // other

            // compare entered and verified password. Only for change password and register screens.
            array('fldVerifyPassword', 'compare', 'compareAttribute'=>'password', 'on'=>array(self::SCENARIO_CHANGE_PASSWORD, self::SCENARIO_REGISTER, self::SCENARIO_FORGOT_PASSWORD)),

            array('date_of_birth',                  'validateAge', 'age_limit' => 18),

            // The following rule is used by search(). It only contains attributes that should be searched.
            array('user_id, user_name, email, first_name, last_name, user_type, status,
                   created_by, modified_by, activation_code, activation_status, activation_time,
                   facebook_id, facebook_name, registered_with_fb, loggedin_with_fb,
                   login_status, last_login, mobile_number, mobile_carrier_id, send_sms_notification,
                   date_of_birth, hometown, marital_status, places_want_to_visit',
                  'safe', 'on'=>'search'),
        );
    }


    /**
     * Set rules for the relation of this record model to other record models.
     *
     * @param <none> <none>
     *
     * @return array relational rules.
     * @access public
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
		return array(
			'advertisements'     => array(self::HAS_MANY, 'Advertisement', 'created_by'),
			'advertisements1'    => array(self::HAS_MANY, 'Advertisement', 'modified_by'),
			'advertisements2'    => array(self::HAS_MANY, 'Advertisement', 'user_id'),
			'businesses'         => array(self::HAS_MANY, 'Business', 'claimed_by'),
			'businesses1'        => array(self::HAS_MANY, 'Business', 'created_by'),
			'businesses2'        => array(self::HAS_MANY, 'Business', 'modified_by'),
			'businesses3'        => array(self::HAS_MANY, 'Business', 'add_request_processed_by'),
			'businessUsers'      => array(self::HAS_MANY, 'BusinessUser', 'user_id'),
			'events'             => array(self::HAS_MANY, 'Event', 'created_by'),
			'events1'            => array(self::HAS_MANY, 'Event', 'modified_by'),
			'mailTemplates'      => array(self::HAS_MANY, 'MailTemplate', 'created_by'),
			'mailTemplates1'     => array(self::HAS_MANY, 'MailTemplate', 'modified_by'),
			'pages'              => array(self::HAS_MANY, 'Page', 'created_by'),
			'pages1'             => array(self::HAS_MANY, 'Page', 'modified_by'),
			'placesSubscribeds'  => array(self::HAS_MANY, 'PlacesSubscribed', 'user_id'),
			'placesVisiteds'     => array(self::HAS_MANY, 'PlacesVisited', 'user_id'),
			'savedSearches'      => array(self::HAS_MANY, 'SavedSearch', 'user_id'),
			'modifiedBy'         => array(self::BELONGS_TO, 'User', 'modified_by'),
			'users'              => array(self::HAS_MANY, 'User', 'modified_by'),
			'createdBy'          => array(self::BELONGS_TO, 'User', 'created_by'),
			'users1'             => array(self::HAS_MANY, 'User', 'created_by'),
			'userEvents'         => array(self::HAS_MANY, 'UserEvent', 'user_id'),
			'mobileCarrier'      => array(self::BELONGS_TO, 'MobileCarrier', 'mobile_carrier_id'),
			'subscribedBusinesses' => array(self::HAS_MANY, 'SubscribedBusiness', 'user_id'),
			'businessRatings'    => array(self::HAS_MANY, 'BusinessRating', 'user_id'),
		);
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
            'user_id'               => 'User',
            'user_name'             => 'User Name',
            'email'                 => 'Email',
            'password'              => 'Password',
            'first_name'            => 'First Name',
            'last_name'             => 'Last Name',
            'user_type'             => 'User Type',
            'status'                => 'Status',
            'activation_code'       => 'Activation Code',
            'activation_status'     => 'Activation Status',
            'facebook_id'           => 'Facebook',
            'facebook_name'         => 'Facebook Name',
            'registered_with_fb'    => 'Registered With Fb',
            'loggedin_with_fb'      => 'Loggedin With Fb',
            'login_status'          => 'Login Status',
            'mobile_number'         => 'Mobile Number',
            'mobile_carrier_id'     => 'Mobile Carrier',
            'send_sms_notification' => 'Send Sms Notification',
            'date_of_birth'         => 'Date Of Birth',
            'hometown'              => 'Hometown',
            'marital_status'        => 'Marital Status',
            'places_want_to_visit'  => 'Places Want To Visit',
            'my_info_permissions'   => 'My Info permissions',
            'photos_permissions'    => 'Photos permissions',
            'friends_permissions'   => 'Friends permissions',
            'blogs_permissions'     => 'Blogs permissions',
            'travel_options_permissions' => 'Travel Options Permissions',
            'image'                 => 'Image',
            'fldVerifyPassword'     => 'Re-enter Password',
            'fldCurrentPassword'    => 'Current Password',
        );
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @param <none> <none>
     *
     * @return CActiveDataProvider the data provider that can return the models
     *         ...based on the search/filter conditions.
     * @access public
     */
    public function search()
    {

        $criteria=new CDbCriteria;

        $criteria->compare('user_id',               $this->user_id);
        $criteria->compare('user_name',             $this->user_name,true);
        $criteria->compare('email',                 $this->email,true);
        $criteria->compare('first_name',            $this->first_name,true);
        $criteria->compare('last_name',             $this->last_name,true);
        $criteria->compare('user_type',             $this->user_type,true);
        $criteria->compare('status',                $this->status,false);
        $criteria->compare('created_by',            $this->created_by);
        $criteria->compare('modified_by',           $this->modified_by);
        $criteria->compare('activation_code',       $this->activation_code,true);
        $criteria->compare('activation_status',     $this->activation_status);
        $criteria->compare('activation_time',       $this->activation_time,true);
        $criteria->compare('facebook_id',           $this->facebook_id,true);
        $criteria->compare('facebook_name',         $this->facebook_name,true);
        $criteria->compare('registered_with_fb',    $this->registered_with_fb);
        $criteria->compare('loggedin_with_fb',      $this->loggedin_with_fb);
        $criteria->compare('login_status',          $this->login_status);
        $criteria->compare('last_login',            $this->last_login,true);
        $criteria->compare('mobile_number',         $this->mobile_number,true);
        $criteria->compare('mobile_carrier_id',     $this->mobile_carrier_id);
        $criteria->compare('send_sms_notification', $this->send_sms_notification,true);
        $criteria->compare('date_of_birth',         $this->date_of_birth,true);
        $criteria->compare('hometown',              $this->hometown,true);
        $criteria->compare('marital_status',        $this->marital_status);
        $criteria->compare('places_want_to_visit',  $this->places_want_to_visit,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return User the static model class
     *
     * @access public
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Runs just before the models save method is invoked. It provides a change to
     * ...further prepare the data for saving. The CActiveRecord (parent class)
     * ...beforeSave is called to process any raised events.
     *
     * @param <none> <none>
     * @return boolean the decision to continue the save or not.
     *
     * @access public
     */
    public function beforeSave() {

        // /////////////////////////////////////////////////////////////////////
        // Some scenarios only require certain fields to be updated. We handle
        // ...this separately.
        // /////////////////////////////////////////////////////////////////////

        if ($this->scenario == self::SCENARIO_LOGIN)
        {
            /** Login scenario */
            $this->last_login = new CDbExpression('NOW()');
        }

        if ($this->scenario == self::SCENARIO_VALIDATION)
        {
            /** Account activation scenario */

            if ($this->activation_status == 'activated')
            {
                $this->activation_code = '';
                $this->status          = 'active';
                $this->activation_time = new CDbExpression('NOW()');
            }
        }

        if ( ($this->scenario == self::SCENARIO_CHANGE_PASSWORD) ||
             ($this->scenario == self::SCENARIO_REGISTER) ||
             ($this->scenario == 'insert') ||
             ($this->scenario == 'update')
           )
        {
            /** Password change scenario */

            // /////////////////////////////////////////////////////////////////////
            // Encrypt the password. Only do this if the password is set
            // /////////////////////////////////////////////////////////////////////
            if (isset($this->password) && (!empty($this->password)))
            {
                $this->password    =  CPasswordHelper::hashPassword($this->password);

            }
        }


        /** All other scenarios */

        // /////////////////////////////////////////////////////////////////////
        // Set the create time and user for new records
        // /////////////////////////////////////////////////////////////////////
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
            $this->created_by   = '1';  // Special case for not logged in user
            $this->modified_by  = '1';
        }
        else
        {
            $this->modified_by   = isset(Yii::app()->user->id)?Yii::app()->user->id:1;
        }

        // /////////////////////////////////////////////////////////////////////
        // The modified log details is set for record creation and update
        // /////////////////////////////////////////////////////////////////////
        $this->modified_time = new CDbExpression('NOW()');

        return parent::beforeSave();
    }

    /**
     * Default scope which is applied to all seaches in the model. The default
     * ...scope is not honored when other scopes are applied. Should not be
     * ...applied to UPDATE
     *
     * @param <none> <none>
     * @return array DbCriteria directives
     *
     * @access public
     */
    public function defaultScope()
    {
        return array(
            'condition'=>"status <> 'deleted'"
        );
    }

    /**
     * Build an associative list of user type values.
     *
     * @param <none> <none>
     * @return array associatve list of user type values
     *
     * @access public
     */
    public function listUserType() {

        return array('superadmin'       => 'SuperAdmin',
                     'admin'            => 'Admin',
                     'user'             => 'User',
                     'business_user'    => 'Business User');
    }

    /**
     * Build an associative list of user status values.
     *
     * @param <none> <none>
     * @return array associatve list of user status values
     *
     * @access public
     */
    public function listStatus() {

        return array('inactive'     => 'Inactive',
                     'active'       => 'Active',
                     // 'deleted'      => 'Deleted',  Don't show this to the user
                     'banned'       => 'Banned');
    }

    /**
     * Build an associative list of activation status values.
     *
     * @param <none> <none>
     * @return array associatve list of activation status values
     *
     * @access public
     */
    public function listActivationStatus() {

        return array('activated' => 'Activated', 'not_activated' => 'Not Activated');
    }

    /**
     * Build an associative list of marital status values.
     *
     * @param <none> <none>
     * @return array associatve list of marital status values
     *
     * @access public
     */
    public function listMaritalStatus() {

        return array('Married' =>'Married', 'Single' => 'Single', 'Unknown' => 'Unknown');
    }

    /**
     * Build an associative list of permission values.
     *
     * @param <none> <none>
     * @return array associatve list of permission status values
     *
     * @access public
     */
    public function listPermissions() {

        return array('none' => 'Do not share','friends' => 'My Friends', 'all' => 'Everybody');
    }

    /**
     * Build an associative list of permission values.
     *
     * @param <none> <none>
     * @return array associatve list of permission status values
     *
     * @access public
     */
    public function getFullname() {

         return $this->first_name . ' ' . $this->last_name;
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
