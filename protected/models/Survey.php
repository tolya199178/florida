<?php

/**
 * This is the model class for table "{{survey}}".
 *
 * The followings are the available columns in table '{{survey}}':
 * @property integer $survey_id
 * @property integer $business_id
 * @property string $survey_name
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $created_time
 * @property string $modified_time
 * @property integer $published
 * @property integer $template
 * @property integer $private
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $createdBy
 * @property User $modifiedBy
 * @property SurveyAnswer[] $surveyAnswers
 * @property SurveyQuestion[] $surveyQuestions
 * @property SurveyResponse[] $surveyResponses
 */

 /**
 * Survey activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = Survey::model()
 * ...or
 * ...   $model = new Survey;
 * ...or
 * ...   $model = new Survey($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class Survey extends CActiveRecord
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
		return '{{survey}}';
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
			array('survey_name', 'required'),
			array('business_id, created_by, modified_by, published, template, private', 'numerical', 'integerOnly'=>true),
			array('survey_name', 'length', 'max'=>255),
			array('created_time, modified_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('survey_id, business_id, survey_name, created_by, modified_by, created_time, modified_time, published, template, private', 'safe', 'on'=>'search'),
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
			'business'      => array(self::BELONGS_TO, 'Business', 'business_id'),
			'createdBy'      => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy'      => array(self::BELONGS_TO, 'User', 'modified_by'),
			'surveyAnswers'      => array(self::HAS_MANY, 'SurveyAnswer', 'survey_id'),
			'surveyQuestions'      => array(self::HAS_MANY, 'SurveyQuestion', 'survey_id', 'order' => 'sort'),
			'surveyResponses'      => array(self::HAS_MANY, 'SurveyResponse', 'survey_id'),
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
			'survey_id'      => 'Survey',
			'business_id'      => 'Business',
			'survey_name'      => 'Survey Name',
			'created_by'      => 'Created By',
			'modified_by'      => 'Modified By',
			'created_time'      => 'Created Time',
			'modified_time'      => 'Modified Time',
			'published'      => 'Published',
			'template'      => 'Template',
			'private'      => 'Private',
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

		$criteria->compare('survey_id',$this->survey_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('survey_name',$this->survey_name,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('template',$this->template);
		$criteria->compare('private',$this->private);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Survey the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
