<?php

/**
 * This is the model class for table "{{survey_question}}".
 *
 * The followings are the available columns in table '{{survey_question}}':
 * @property integer $survey_question_id
 * @property integer $survey_id
 * @property integer $survey_question_type_id
 * @property string $question
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property SurveyAnswer[] $surveyAnswers
 * @property Survey $survey
 * @property SurveyQuestionType $surveyQuestionType
 * @property SurveyQuestionOption[] $surveyQuestionOptions
 */

 /**
 * SurveyQuestion activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = SurveyQuestion::model()
 * ...or
 * ...   $model = new SurveyQuestion;
 * ...or
 * ...   $model = new SurveyQuestion($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class SurveyQuestion extends CActiveRecord
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
		return '{{survey_question}}';
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
			array('survey_id, survey_question_type_id, question, sort',  'required'),
			array('survey_id, survey_question_type_id, sort',            'numerical', 'integerOnly'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('survey_question_id, survey_id, survey_question_type_id, question, sort', 'safe', 'on'=>'search'),
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
			'surveyAnswers'          => array(self::HAS_MANY,   'SurveyAnswer', 'survey_question_id'),
			'survey'                 => array(self::BELONGS_TO, 'Survey', 'survey_id'),
			'surveyQuestionType'     => array(self::BELONGS_TO, 'SurveyQuestionType', 'survey_question_type_id'),
			'surveyQuestionOptions'  => array(self::HAS_MANY,   'SurveyQuestionOption', 'question_id', 'order' => 'sort'),
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
			'survey_question_id'         => 'Survey Question',
			'survey_id'                  => 'Survey',
			'survey_question_type_id'    => 'Survey Question Type',
			'question'                   => 'Question',
			'sort'                       => 'Sort',
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

		$criteria->compare('survey_question_id',          $this->survey_question_id);
		$criteria->compare('survey_id',                   $this->survey_id);
		$criteria->compare('survey_question_type_id',     $this->survey_question_type_id);
		$criteria->compare('question',                    $this->question,true);
		$criteria->compare('sort',                        $this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return SurveyQuestion the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
