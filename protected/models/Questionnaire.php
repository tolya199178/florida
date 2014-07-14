<?php

/**
 * This is the model class for table "{{questionnaire}}".
 *
 * The followings are the available columns in table '{{questionnaire}}':
 * @property integer $questionnaire_id
 * @property string $title
 * @property string $question
 * @property string $question_type
 * @property string $answer
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $business_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $createdBy
 * @property User $modifiedBy
 * @property User $user
 */

/**
 * Questionnaire activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = Questionnaire::model()
 * ...or
 * ...   $model = new Questionnaire;
 * ...or
 * ...   $model = new Questionnaire($scenario);
 *
 * @package   Components
 * @author    Pradesh Chanderpaul <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class Questionnaire extends CActiveRecord
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
        return '{{questionnaire}}';
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
            array('title, question, answer',                'required'),
            array('business_id, user_id',                   'numerical', 'integerOnly'=>true),
            array('title, question',                        'length', 'max'=>255),
            array('question_type',                          'in', 'range'=>array('Subjective','Objective')),
            array('answer',                                 'length', 'max'=>4096),

            // The following rule is used by search(). It only contains attributes that should be searched.
            array('questionnaire_id, title, question, question_type, answer, created_time, modified_time, created_by, modified_by, business_id, user_id', 'safe', 'on'=>'search'),
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
            'business'          => array(self::BELONGS_TO, 'Business', 'business_id'),
            'createdBy'         => array(self::BELONGS_TO, 'User', 'created_by'),
            'modifiedBy'        => array(self::BELONGS_TO, 'User', 'modified_by'),
            'user'              => array(self::BELONGS_TO, 'User', 'user_id'),
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
            'questionnaire_id'          => 'Questionnaire',
            'title'                     => 'Title',
            'question'                  => 'Question',
            'question_type'             => 'Question Type',
            'answer'                    => 'Answer',
            'created_time'              => 'Created Time',
            'modified_time'             => 'Modified Time',
            'created_by'                => 'Created By',
            'modified_by'               => 'Modified By',
            'business_id'               => 'Business',
            'user_id'                   => 'User',
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

        $criteria->compare('questionnaire_id',      $this->questionnaire_id);
        $criteria->compare('title',                 $this->title,true);
        $criteria->compare('question',              $this->question,true);
        $criteria->compare('question_type',         $this->question_type);
        $criteria->compare('answer',                $this->answer,true);
        $criteria->compare('created_time',          $this->created_time,true);
        $criteria->compare('modified_time',         $this->modified_time,true);
        $criteria->compare('created_by',            $this->created_by);
        $criteria->compare('modified_by',           $this->modified_by);
        $criteria->compare('business_id',           $this->business_id);
        $criteria->compare('user_id',               $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Questionnaire the static model class
     *
     * @access public
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Runs just before the models save method is invoked. It provides a change to
     * ...further prepare the data for saving. The CActiveRecord (parent class)
     * ...beforeSave is called to process any raised events.
     *
     * @param <none> <none>
     * @return boolean the decision to continue the save or not.
     *
     * @access public
     */
    public function beforeSave() {

        // /////////////////////////////////////////////////////////////////
        // Set the create time and user for new records
        // /////////////////////////////////////////////////////////////////
        if ($this->isNewRecord) {
            $this->created_time = new CDbExpression('NOW()');
            $this->created_by   = Yii::app()->user->id;
        }

        // /////////////////////////////////////////////////////////////////
        // The modified log details is set for record creation and update
        // /////////////////////////////////////////////////////////////////
        $this->modified_time = new CDbExpression('NOW()');
        $this->modified_by   = Yii::app()->user->id;


        return parent::beforeSave();
    }

    /**
     * Build an associative list of question types.
     *
     * @param <none> <none>
     * @return array associatve list of question types
     *
     * @access public
     */
    public function listType()
    {

        return array('objective'        => 'Objective',
                     'subjective'       => 'Subjective');
    }
}
