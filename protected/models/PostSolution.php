<?php

/**
 * This is the model class for table "{{post_solution}}".
 *
 * The followings are the available columns in table '{{post_solution}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property integer $category_id
 * @property string $created_date
 * @property string $modified_date
 * @property string $status
 * @property string $message
 * @property integer $reply_to
 *
 * The followings are the available model relations:
 * @property PostSolution $replyTo
 * @property PostSolution[] $postSolutions
 * @property User $user
 */

 /**
 * PostSolution activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $post = PostSolution::model()
 * ...or
 * ...   $post = new PostSolution;
 * ...or
 * ...   $post = new PostSolution($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PostSolution extends CActiveRecord
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
		return '{{post_solution}}';
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
			array('user_id, title, category_id, created_date, message', 'required'),
			array('user_id, category_id, reply_to', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('status', 'length', 'max'=>6),
			array('modified_date', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('id, user_id, title, category_id, created_date, modified_date, status, message, reply_to', 'safe', 'on'=>'search'),
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
			'replyTo'      => array(self::BELONGS_TO, 'PostSolution', 'reply_to'),
			'postSolutions'      => array(self::HAS_MANY, 'PostSolution', 'reply_to'),
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
			'id'      => 'ID',
			'user_id'      => 'User',
			'title'      => 'Title',
			'category_id'      => 'Category',
			'created_date'      => 'Created Date',
			'modified_date'      => 'Modified Date',
			'status'      => 'Status',
			'message'      => 'Message',
			'reply_to'      => 'Reply To',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('reply_to',$this->reply_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PostSolution the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
