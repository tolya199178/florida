<?php

/**
 * This is the model class for table "{{post_subscribed}}".
 *
 * The followings are the available columns in table '{{post_subscribed}}':
 * @property integer $post_subscribed_id
 * @property integer $user_id
 * @property integer $post_id
 *
 * The followings are the available model relations:
 * @property PostQuestion $post
 * @property User $user
 */

 /**
 * PostSubscribed activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $subscription = PostSubscribed::model()
 * ...or
 * ...   $subscription = new PostSubscribed;
 * ...or
 * ...   $subscription = new PostSubscribed($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PostSubscribed extends CActiveRecord
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
		return '{{post_subscribed}}';
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
			array('user_id, post_id', 'required'),
			array('user_id, post_id', 'numerical', 'integerOnly'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('post_subscribed_id, user_id, post_id', 'safe', 'on'=>'search'),
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
			'post'      => array(self::BELONGS_TO, 'PostQuestion', 'post_id'),
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
			'post_subscribed_id'     => 'Post Subscribed',
			'user_id'                => 'User',
			'post_id'                => 'Post',
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

		$criteria->compare('post_subscribed_id',  $this->post_subscribed_id);
		$criteria->compare('user_id',             $this->user_id);
		$criteria->compare('post_id',             $this->post_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PostSubscribed the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
