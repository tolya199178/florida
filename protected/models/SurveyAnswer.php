<?php

/**
 * This is the model class for table "{{survey_answer}}".
 *
 * The followings are the available columns in table '{{survey_answer}}':
 * @property integer $survey_answer_id
 * @property integer $survey_id
 * @property integer $survey_response_id
 * @property integer $survey_question_id
 * @property integer $user_id
 * @property string $answer
 * @property integer $survey_question_option_id
 * @property string $created_time
 *
 * The followings are the available model relations:
 * @property SurveyQuestion $surveyQuestion
 * @property User $user
 * @property Survey $survey
 * @property SurveyResponse $surveyResponse
 */

 /**
 * SurveyAnswer activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = SurveyAnswer::model()
 * ...or
 * ...   $model = new SurveyAnswer;
 * ...or
 * ...   $model = new SurveyAnswer($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class SurveyAnswer extends CActiveRecord
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
		return '{{survey_answer}}';
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
			array('survey_id, survey_response_id, survey_question_id, user_id, answer, survey_question_option_id', 'required'),
			array('survey_id, survey_response_id, survey_question_id, user_id, survey_question_option_id', 'numerical', 'integerOnly'=>true),
			array('answer', 'length', 'max'=>255),
			array('created_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('survey_answer_id, survey_id, survey_response_id, survey_question_id, user_id, answer, survey_question_option_id, created_time', 'safe', 'on'=>'search'),
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
			'surveyQuestion'      => array(self::BELONGS_TO, 'SurveyQuestion', 'survey_question_id'),
			'user'      => array(self::BELONGS_TO, 'User', 'user_id'),
			'survey'      => array(self::BELONGS_TO, 'Survey', 'survey_id'),
			'surveyResponse'      => array(self::BELONGS_TO, 'SurveyResponse', 'survey_response_id'),
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
			'survey_answer_id'      => 'Survey Answer',
			'survey_id'      => 'Survey',
			'survey_response_id'      => 'Survey Response',
			'survey_question_id'      => 'Survey Question',
			'user_id'      => 'User',
			'answer'      => 'Answer',
			'survey_question_option_id'      => 'Survey Question Option',
			'created_time'      => 'Created Time',
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

		$criteria->compare('survey_answer_id',$this->survey_answer_id);
		$criteria->compare('survey_id',$this->survey_id);
		$criteria->compare('survey_response_id',$this->survey_response_id);
		$criteria->compare('survey_question_id',$this->survey_question_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('survey_question_option_id',$this->survey_question_option_id);
		$criteria->compare('created_time',$this->created_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return SurveyAnswer the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
