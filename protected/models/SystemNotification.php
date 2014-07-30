<?php

/**
 * This is the model class for table "{{system_notification}}".
 *
 * The followings are the available columns in table '{{system_notification}}':
 * @property integer $system_notification_id
 * @property string $entity_type
 * @property integer $entity_id
 * @property string $title
 * @property string $description
 * @property string $history
 * @property string $status
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property User $createdBy
 */

 /**
 * SystemNotification activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = SystemNotification::model()
 * ...or
 * ...   $model = new SystemNotification;
 * ...or
 * ...   $model = new SystemNotification($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class SystemNotification extends CActiveRecord
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
		return '{{system_notification}}';
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
			array('entity_id, title',                        'required'),
			array('entity_id', 'numerical',                  'integerOnly'=>true),
		    array('title',                                   'length', 'max'=>255),
		    array('description',                             'length', 'max'=>4096),
		    array('history',                                 'length', 'max'=>64000),

		    array('trip_status',
		          'in', 'range'=>array('new', 'active', 'pending', 'closed', 'archived')),


			array('entity_type',
			      'in', 'range'=>array('city', 'state', 'business', 'user', 'general', 'event')),


            // The following rule is used by search(). It only contains attributes that should be searched.
			array('system_notification_id, entity_type, entity_id, title, description, history, status, created_time, modified_time, created_by, modified_by', 'safe', 'on'=>'search'),
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
			'modifiedBy'         => array(self::BELONGS_TO, 'User', 'modified_by'),
			'createdBy'          => array(self::BELONGS_TO, 'User', 'created_by'),
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
			'system_notification_id'     => 'System Notification',
			'entity_type'                => 'Entity Type',
			'entity_id'                  => 'Entity',
			'title'                      => 'Event Title',
			'description'                => 'Event Description',
			'history'                    => 'History',
			'status'                     => 'Status',
			'created_time'               => 'Created Time',
			'modified_time'              => 'Modified Time',
			'created_by'                 => 'Created By',
			'modified_by'                => 'Modified By',
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

		$criteria->compare('system_notification_id',  $this->system_notification_id);
		$criteria->compare('entity_type',             $this->entity_type,true);
		$criteria->compare('entity_id',               $this->entity_id);
		$criteria->compare('title',                   $this->title,true);
		$criteria->compare('description',             $this->description,true);
		$criteria->compare('history',                 $this->history,true);
		$criteria->compare('status',                  $this->status,true);
		$criteria->compare('created_time',            $this->created_time,true);
		$criteria->compare('modified_time',           $this->modified_time,true);
		$criteria->compare('created_by',              $this->created_by);
		$criteria->compare('modified_by',             $this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return SystemNotification the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
