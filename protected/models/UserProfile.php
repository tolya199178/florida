<?php

/**
 * This is the model class for table "{{user_profile}}".
 *
 * The followings are the available columns in table '{{user_profile}}':
 * @property integer $user_profile_id
 * @property integer $user_id
 * @property string $alert_business_review
 * @property string $alert_review_comment
 * @property string $alert_like_complaint_response
 * @property string $alert_forum_response
 * @property string $alert_answer_voted
 * @property string $alert_trip_question_response
 *
 * The followings are the available model relations:
 * @property User $user
 */

 /**
 * UserProfile activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $profile_setting = UserProfile::model()
 * ...or
 * ...   $profile_setting = new UserProfile;
 * ...or
 * ...   $profile_setting = new UserProfile($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class UserProfile extends CActiveRecord
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
		return '{{user_profile}}';
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
			array('user_id',                                             'required'),
			array('user_id',                                             'numerical', 'integerOnly'=>true),
			array('alert_business_review, alert_review_comment,
			       alert_like_complaint_response, alert_forum_response,
			       alert_answer_voted, alert_trip_question_response',    'in', 'range'=>array('Y','N'),
			                                                             'allowEmpty'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('user_profile_id, user_id, alert_business_review, alert_review_comment,
			       alert_like_complaint_response, alert_forum_response,
			       alert_answer_voted, alert_trip_question_response',    'safe', 'on'=>'search'),
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
			'user_profile_id'                    => 'User Profile ID',
			'user_id'                            => 'User',
			'alert_business_review'              => 'Alert Business Reviews',
			'alert_review_comment'               => 'Alert Review Comments',
			'alert_like_complaint_response'      => 'Alert Like Complaint Responses',
			'alert_forum_response'               => 'Alert Forum Responses',
			'alert_answer_voted'                 => 'Alert Answer Votes',
			'alert_trip_question_response'       => 'Alert Trip Question Responses',
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

		$criteria->compare('user_profile_id',                 $this->user_profile_id);
		$criteria->compare('user_id',                         $this->user_id);
		$criteria->compare('alert_business_review',           $this->alert_business_review);
		$criteria->compare('alert_review_comment',            $this->alert_review_comment);
		$criteria->compare('alert_like_complaint_response',   $this->alert_like_complaint_response);
		$criteria->compare('alert_forum_response',            $this->alert_forum_response);
		$criteria->compare('alert_answer_voted',              $this->alert_answer_voted);
		$criteria->compare('alert_trip_question_response',    $this->alert_trip_question_response);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return UserProfile the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
