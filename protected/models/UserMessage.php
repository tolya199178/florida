<?php

/**
 * This is the model class for table "{{user_message}}".
 *
 * The followings are the available columns in table '{{user_message}}':
 * @property integer $id
 * @property integer $sender
 * @property integer $recipient
 * @property string $sent
 * @property string $read
 * @property string $subject
 * @property string $message
 * @property integer $reply_to
 *
 * The followings are the available model relations:
 * @property User $sender_user
 * @property User $recipient_user
 */

 /**
 * UserMessage activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $message = UserMessage::model()
 * ...or
 * ...   $message = new UserMessage;
 * ...or
 * ...   $message = new UserMessage($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class UserMessage extends CActiveRecord
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
		return '{{user_message}}';
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

		    // Mandatory rules
			array('sender, recipient, subject, message',                 'required'),

		    // Data types, sizes
			array('sender, recipient, reply_to',                         'numerical', 'integerOnly'=>true),
			array('read',                                                'in', 'range'=>array('Y','N')),
			array('subject',                                             'length', 'max'=>255),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('id, sender, recipient, sent, read, subject, message, reply_to', 'safe', 'on'=>'search'),
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
			'sender_user'            => array(self::BELONGS_TO, 'User', 'sender'),
			'recipient_user'         => array(self::BELONGS_TO, 'User', 'recipient'),
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
			'id'             => 'ID',
			'sender'         => 'Sender',
			'recipient'      => 'Recipient',
			'sent'           => 'Sent',
			'read'           => 'Read',
			'subject'        => 'Subject',
			'message'        => 'Message',
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

		$criteria->compare('id',              $this->id);
		$criteria->compare('sender',          $this->sender);
		$criteria->compare('recipient',       $this->recipient);
		$criteria->compare('sent',            $this->sent,true);
		$criteria->compare('read',            $this->read,true);
		$criteria->compare('subject',         $this->subject,true);
		$criteria->compare('message',         $this->message,true);
		$criteria->compare('reply_to',        $this->reply_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return UserMessage the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
