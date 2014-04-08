<?php

/**
 * This is the model class for table "{{business_review}}".
 *
 * The followings are the available columns in table '{{business_review}}':
 * @property integer $business_review_id
 * @property integer $business_id
 * @property integer $user_id
 * @property integer $review$rating
 * @property string $review_text
 * @property string $review_reply
 * @property string $review_date
 * @property string $publish_status
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $user
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $review = Businessreview::model()
 * ...or
 * ...   $review = new Businessreview;
 * ...or
 * ...   $review = new Businessreview($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Businessreview extends CActiveRecord
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
		return '{{business_review}}';
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
			array('business_id, user_id',            'required'),
			array('business_id, user_id, rating',    'numerical', 'integerOnly'=>true),

		    array('review_text, review_reply',       'length', 'max'=>1024),

		    array('publish_status',                  'in','range'=>array('Y','N'),'allowEmpty'=>false),

		    // The following rule is used by search(). It only contains attributes that should be searched.

		    array('business_review_id, business_id, user_id, review, rating, review_text, review_reply, review_date, publish_status', 'safe', 'on'=>'search'),

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
			'business'   => array(self::BELONGS_TO, 'Business', 'business_id'),
			'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
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

		$criteria->compare('business_review_id',  $this->business_review_id);
		$criteria->compare('business_id',         $this->business_id);
		$criteria->compare('user_id',             $this->user_id);
		$criteria->compare('rating',              $this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	        'business_review_id'   => 'Business Review',
	        'business_id'          => 'Business',
	        'user_id'              => 'User',
	        'rating'               => 'Rating',
	        'review_text'          => 'Review Text',
	        'review_reply'         => 'Review Reply',
	        'review_date'          => 'Review Date',
	        'publish_status'       => 'Publish Status',
	    );
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 * @return Businessreview the static model class
	 *
	 * @access public
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
