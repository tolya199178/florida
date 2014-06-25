<?php

/**
 * This is the model class for table "{{my_friend}}".
 *
 * The followings are the available columns in table '{{my_friend}}':
 * @property integer $my_friend_id
 * @property integer $user_id
 * @property integer $friend_id
 * @property string $created_time
 * @property string $connected_by
 * @property string $friend_status
 * @property string $request_time
 * @property string $process_time
 *
 * The followings are the available model relations:
 * @property User $friend
 * @property User $user
 */

 /**
 * MyFriend activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $fiend = MyFriend::model()
 * ...or
 * ...   $fiend = new MyFriend;
 * ...or
 * ...   $fiend = new MyFriend($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class MyFriend extends CActiveRecord
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
		return '{{my_friend}}';
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
			array('user_id, friend_id',      'required'),
			array('user_id, friend_id',      'numerical', 'integerOnly'=>true),
			array('connected_by',            'length', 'max'=>255),

		    array('friend_status',           'length', 'max'=>8),
		    array('isreadonly',              'in',
		                                     'range'=>array('Pending', 'Approved', 'Rejected'),
		                                     'allowEmpty'=>false),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('my_friend_id, user_id, friend_id', 'safe', 'on'=>'search'),
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
			'friend'         => array(self::BELONGS_TO, 'User', 'friend_id'),
			'user'           => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'my_friend_id'       => 'My Friend Id',
			'user_id'            => 'User',
			'friend_id'          => 'Friend',
			'created_time'       => 'Created Time',
			'connected_by'       => 'Connected By',
		    'friend_status'      => 'Friend Status',
		    'request_time'       => 'Request Time',
		    'process_time'       => 'Process time',
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

		$criteria->compare('my_friend_id',    $this->my_friend_id);
		$criteria->compare('user_id',         $this->user_id);
		$criteria->compare('friend_id',       $this->friend_id);
		$criteria->compare('created_time',    $this->created_time,true);
		$criteria->compare('connected_by',    $this->connected_by);
		$criteria->compare('friend_status',   $this->friend_status);
		$criteria->compare('request_time',    $this->request_time,true);
		$criteria->compare('process_time',    $this->process_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MyFriend the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * Returns summary count of friends by user by friend_status
	 *
	 * This function forms a wrapper around the data results to account for
	 * ...missing status fields, which will not be reported if there are no
	 * ...results for the status for the user. The results are provided with a
	 * ..,count for each friend_status value in the column definition.
	 *
	 * If a userid is supplied, then the details are provided for the user,
	 * ...otherwise summary details are provided for all users.
	 *
	 * @param integer $userId Optional user to send results for
	 * @return array The list of friends grouped (optionally) by user and status
	 *
	 * @access public
	 */
	public static function FriendSummary($userId = null)
	{

        $cmdFriendSummary = Yii::app()->db->createCommand()
                                      ->select(array('user_id',
                                                     'SUM(CASE WHEN friend_status = "Pending"
                                                               THEN 1
                                                               ELSE 0 END) AS pending',
                                                     'SUM(CASE WHEN friend_status = "Approved"
                                                               THEN 1
                                                               ELSE 0 END) AS approved',
                                                     'SUM(CASE WHEN friend_status = "Rejected"
                                                               THEN 1
                                                               ELSE 0 END) AS rejected'
                                        ))
                                      ->from('tbl_my_friend');

        if ($userId != null)
        {
            $cmdFriendSummary->where('user_id = :user_id', array(':user_id' => $userId));
        }

        $cmdFriendSummary->group('user_id');

        $resultsFriendSummary = $cmdFriendSummary->queryAll();

        return $resultsFriendSummary;

	}

}
