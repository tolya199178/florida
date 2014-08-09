<?php

/**
 * This is the model class for table "{{my_invitation}}".
 *
 * The followings are the available columns in table '{{my_invitation}}':
 * @property integer $invitation_id
 * @property integer $business_id
 * @property integer $user_id
 * @property string $event_date
 * @property string $event_time
 * @property string $message
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $createdBy
 * @property User $modifiedBy
 * @property User $user
 */

 /**
 * MyInvitation activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = MyInvitation::model()
 * ...or
 * ...   $model = new MyInvitation;
 * ...or
 * ...   $model = new MyInvitation($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class MyInvitation extends CActiveRecord
{

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
		return '{{my_invitation}}';
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

		return array(
			array('business_id, user_id, event_date, created_by, modified_by', 'required'),
			array('business_id, user_id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('event_time', 'length', 'max'=>255),
			array('message', 'length', 'max'=>4096),
			array('created_time, modified_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('invitation_id, business_id, user_id, event_date, event_time, message, created_time, modified_time, created_by, modified_by', 'safe', 'on'=>'search'),
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

		return array(
			'business'      => array(self::BELONGS_TO, 'Business', 'business_id'),
			'createdBy'      => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy'      => array(self::BELONGS_TO, 'User', 'modified_by'),
			'user'      => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'invitation_id'      => 'Invitation',
			'business_id'      => 'Business',
			'user_id'      => 'User',
			'event_date'      => 'Event Date',
			'event_time'      => 'Event Time',
			'message'      => 'Message',
			'created_time'      => 'Created Time',
			'modified_time'      => 'Modified Time',
			'created_by'      => 'Created By',
			'modified_by'      => 'Modified By',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('invitation_id',$this->invitation_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('event_date',$this->event_date,true);
		$criteria->compare('event_time',$this->event_time,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MyInvitation the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
