<?php

/**
 * This is the model class for table "{{activity_type}}".
 *
 * The followings are the available columns in table '{{activity_type}}':
 * @property integer $activity_type_id
 * @property string $keyword
 * @property integer $activity_id
 * @property string $language
 * @property string $related_words
 *
 * The followings are the available model relations:
 * @property Activity $activity
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $activity_type = ActivityType::model()
 * ...or
 * ...   $activity_type = new ActivityType;
 * ...or
 * ...   $activity_type = new ActivityType($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class ActivityType extends CActiveRecord
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
		return '{{activity_type}}';
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
			array('keyword, activity_id',        'required'),
			array('activity_id', 'numerical',    'integerOnly'=>true),
			array('keyword',                     'length', 'max'=>255),
			array('language',                    'length', 'max'=>8),
			array('related_words',               'length', 'max'=>1024),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('keyword, activity_id, language, related_words', 'safe', 'on'=>'search'),
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
			'activity' => array(self::BELONGS_TO, 'Activity', 'activity_id'),
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
			'keyword' =>             'Keyword',
			'activity_id' =>         'Activity',
			'language' =>            'Language',
			'related_words' =>       'Related Words',
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

		$criteria->compare('keyword',             $this->keyword,true);
		$criteria->compare('activity_id',         $this->activity_id);
		$criteria->compare('language',            $this->language,true);
		$criteria->compare('related_words',       $this->related_words,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return ActivityType the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
