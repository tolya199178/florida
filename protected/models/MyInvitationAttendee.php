<?php

/**
 * This is the model class for table "{{my_invitation_attendee}}".
 *
 * The followings are the available columns in table '{{my_invitation_attendee}}':
 * @property integer $invitation_attendees_id
 * @property integer $invitation_id
 * @property integer $user_id
 * @property string $status
 */

 /**
 * MyInvitationAttendees activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = MyInvitationAttendees::model()
 * ...or
 * ...   $model = new MyInvitationAttendees;
 * ...or
 * ...   $model = new MyInvitationAttendees($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class MyInvitationAttendee extends CActiveRecord
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
		return '{{my_invitation_attendee}}';
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
			array('invitation_id, user_id',                  'required'),
			array('invitation_id, user_id',                  'numerical', 'integerOnly'=>true),

		    array('status',
		          'in', 'range'=>array('No response','Attending', 'Not attending')),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('invitation_attendees_id, invitation_id, user_id, status', 'safe', 'on'=>'search'),
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
			'invitation' => array(self::BELONGS_TO, 'MyInvitation', 'invitation_id'),
			'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'invitation_attendees_id'        => 'Invitation Attendees',
			'invitation_id'                  => 'Invitation',
			'user_id'                        => 'User',
			'status'                         => 'Status',
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

		$criteria->compare('invitation_attendees_id',     $this->invitation_attendees_id);
		$criteria->compare('invitation_id',               $this->invitation_id);
		$criteria->compare('user_id',                     $this->user_id);
		$criteria->compare('status',                      $this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MyInvitationAttendees the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
