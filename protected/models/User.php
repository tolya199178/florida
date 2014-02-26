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
 * @property string $my_info_permssions
 * @property string $photos_permssions
 * @property string $friends_permssions
 * @property string $blogs_permssions
 * @property string $travel_options_permissions
 * @property string $image
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property User[] $users
 * @property User $createdBy
 * @property User[] $users1
 */
class User extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_name, modified_time, created_by, modified_by, mobile_carrier_id', 'required'),
            array('created_by, modified_by, mobile_carrier_id', 'numerical', 'integerOnly'=>true),
            array('user_name, email, first_name, last_name, activation_code, facebook_id, facebook_name, hometown, places_want_to_visit, image', 'length', 'max'=>255),
            array('password', 'length', 'max'=>512),
            array('user_type, activation_status', 'length', 'max'=>13),
            array('status', 'length', 'max'=>8),
            array('registered_with_fb, loggedin_with_fb, send_sms_notification', 'length', 'max'=>1),
            array('login_status', 'length', 'max'=>10),
            array('mobile_number', 'length', 'max'=>64),
            array('marital_status, my_info_permssions, photos_permssions, friends_permssions, blogs_permssions, travel_options_permissions', 'length', 'max'=>7),
            array('created_time, activation_time, last_login, date_of_birth', 'safe'),

            
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, user_name, email, password, first_name, last_name, user_type, status, created_time, modified_time, created_by, modified_by, activation_code, activation_status, activation_time, facebook_id, facebook_name, registered_with_fb, loggedin_with_fb, login_status, last_login, mobile_number, mobile_carrier_id, send_sms_notification, date_of_birth, hometown, marital_status, places_want_to_visit, my_info_permssions, photos_permssions, friends_permssions, blogs_permssions, travel_options_permissions, image', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
            'users' => array(self::HAS_MANY, 'User', 'modified_by'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'users1' => array(self::HAS_MANY, 'User', 'created_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'user_name' => 'User Name',
            'email' => 'Email',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_type' => 'User Type',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'activation_code' => 'Activation Code',
            'activation_status' => 'Activation Status',
            'activation_time' => 'Activation Time',
            'facebook_id' => 'Facebook',
            'facebook_name' => 'Facebook Name',
            'registered_with_fb' => 'Registered With Fb',
            'loggedin_with_fb' => 'Loggedin With Fb',
            'login_status' => 'Login Status',
            'last_login' => 'Last Login',
            'mobile_number' => 'Mobile Number',
            'mobile_carrier_id' => 'Mobile Carrier',
            'send_sms_notification' => 'Send Sms Notification',
            'date_of_birth' => 'Date Of Birth',
            'hometown' => 'Hometown',
            'marital_status' => 'Marital Status',
            'places_want_to_visit' => 'Places Want To Visit',
            'my_info_permssions' => 'My Info Permssions',
            'photos_permssions' => 'Photos Permssions',
            'friends_permssions' => 'Friends Permssions',
            'blogs_permssions' => 'Blogs Permssions',
            'travel_options_permissions' => 'Travel Options Permissions',
            'image' => 'Image',
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
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('user_name',$this->user_name,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('first_name',$this->first_name,true);
        $criteria->compare('last_name',$this->last_name,true);
        $criteria->compare('user_type',$this->user_type,true);
        $criteria->compare('status',$this->status,true);
        $criteria->compare('created_time',$this->created_time,true);
        $criteria->compare('modified_time',$this->modified_time,true);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('modified_by',$this->modified_by);
        $criteria->compare('activation_code',$this->activation_code,true);
        $criteria->compare('activation_status',$this->activation_status,true);
        $criteria->compare('activation_time',$this->activation_time,true);
        $criteria->compare('facebook_id',$this->facebook_id,true);
        $criteria->compare('facebook_name',$this->facebook_name,true);
        $criteria->compare('registered_with_fb',$this->registered_with_fb,true);
        $criteria->compare('loggedin_with_fb',$this->loggedin_with_fb,true);
        $criteria->compare('login_status',$this->login_status,true);
        $criteria->compare('last_login',$this->last_login,true);
        $criteria->compare('mobile_number',$this->mobile_number,true);
        $criteria->compare('mobile_carrier_id',$this->mobile_carrier_id);
        $criteria->compare('send_sms_notification',$this->send_sms_notification,true);
        $criteria->compare('date_of_birth',$this->date_of_birth,true);
        $criteria->compare('hometown',$this->hometown,true);
        $criteria->compare('marital_status',$this->marital_status,true);
        $criteria->compare('places_want_to_visit',$this->places_want_to_visit,true);
        $criteria->compare('my_info_permssions',$this->my_info_permssions,true);
        $criteria->compare('photos_permssions',$this->photos_permssions,true);
        $criteria->compare('friends_permssions',$this->friends_permssions,true);
        $criteria->compare('blogs_permssions',$this->blogs_permssions,true);
        $criteria->compare('travel_options_permissions',$this->travel_options_permissions,true);
        $criteria->compare('image',$this->image,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}