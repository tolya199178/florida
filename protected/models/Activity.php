<?php

/**
 * This is the model class for table "{{activity}}".
 *
 * The followings are the available columns in table '{{activity}}':
 * @property integer $activity_id
 * @property string $keyword
 * @property string $language
 * @property string $related_words
 * @property string $event_categories
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $activity = Activity::model()
 * ...or
 * ...   $activity = new Activity;
 * ...or
 * ...   $activity = new Activity($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Activity extends CActiveRecord
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
		return '{{activity}}';
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
		    array('keyword',         'required'),

		    // Data types, sizes
			array('keyword',         'length', 'max'=>255),
		    array('language',        'default', 'value'=>'en'),
			array('language',        'length', 'max'=>8),

		    array('related_words,
		           event_categories','length', 'max'=>1024),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('activity_id, keyword, language, related_words, event_categories', 'safe', 'on'=>'search'),
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
	        'businessActivities' => array(self::HAS_MANY, 'BusinessActivity', 'activity_id'),
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
			'activity_id'    => 'Activity',
			'keyword'        => 'Keyword',
			'language'       => 'Language',
			'related_words'  => 'Related Words (separate by comma)',
		    'event_categories'=> 'Event Categories (separate by comma)',
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

		$criteria=new CDbCriteria;

		$criteria->compare('activity_id',     $this->activity_id);
		$criteria->compare('keyword',         $this->keyword,true);
		$criteria->compare('language',        $this->language,true);
		$criteria->compare('related_words',   $this->related_words,true);
		$criteria->compare('event_categories',$this->event_categories,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Activity the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Generates a JSON encoded list of all activities.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function getListjson()
    {

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria();

        $lstActivity = Activity::model()->findAll($searchCriteria);

        $listResults = array();

        foreach ($lstActivity as $recActivity) {
            // $listResults[] = array('keyword' => $recActivity->attributes['keyword']);
            $listResults[] = $recActivity->attributes['keyword'];
        }
        // header('Content-type: application/json');

        return CJSON::encode($listResults);
    }

}
