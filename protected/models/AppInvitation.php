<?php

/**
 * This is the model class for table "{{app_invitation}}".
 *
 * The followings are the available columns in table '{{app_invitation}}':
 * @property integer $invitation_id
 * @property integer $user_id
 * @property integer $friend_id
 * @property string $created_time
 * @property string $connected_by
 * @property string $request_time
 * @property string $process_time
 *
 * The followings are the available model relations:
 * @property User $friend
 * @property User $user
 */

 /**
 * AppInvitation activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = AppInvitation::model()
 * ...or
 * ...   $model = new AppInvitation;
 * ...or
 * ...   $model = new AppInvitation($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class AppInvitation extends CActiveRecord
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
		return '{{app_invitation}}';
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
			array('user_id, friend_id', 'required'),
			array('user_id, friend_id', 'numerical', 'integerOnly'=>true),
			array('connected_by', 'length', 'max'=>255),
			array('created_time, request_time, process_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('invitation_id, user_id, friend_id, created_time, connected_by, request_time, process_time', 'safe', 'on'=>'search'),
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
			'friend'      => array(self::BELONGS_TO, 'User', 'friend_id'),
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
			'user_id'      => 'User',
			'friend_id'      => 'Friend',
			'created_time'      => 'Created Time',
			'connected_by'      => 'Connected By',
			'request_time'      => 'Request Time',
			'process_time'      => 'Process Time',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('friend_id',$this->friend_id);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('connected_by',$this->connected_by,true);
		$criteria->compare('request_time',$this->request_time,true);
		$criteria->compare('process_time',$this->process_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return AppInvitation the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
