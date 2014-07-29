<?php

/**
 * This is the model class for table "{{survey_question_option}}".
 *
 * The followings are the available columns in table '{{survey_question_option}}':
 * @property integer $survey_question_option_id
 * @property integer $question_id
 * @property string $value
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property SurveyQuestion $question
 */

 /**
 * SurveyQuestionOption activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = SurveyQuestionOption::model()
 * ...or
 * ...   $model = new SurveyQuestionOption;
 * ...or
 * ...   $model = new SurveyQuestionOption($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class SurveyQuestionOption extends CActiveRecord
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
		return '{{survey_question_option}}';
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
			array('question_id, value, sort', 'required'),
			array('question_id, sort', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>255),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('survey_question_option_id, question_id, value, sort', 'safe', 'on'=>'search'),
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
			'question'      => array(self::BELONGS_TO, 'SurveyQuestion', 'question_id'),
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
			'survey_question_option_id'      => 'Survey Question Option',
			'question_id'      => 'Question',
			'value'      => 'Value',
			'sort'      => 'Sort',
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

		$criteria->compare('survey_question_option_id',$this->survey_question_option_id);
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return SurveyQuestionOption the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
