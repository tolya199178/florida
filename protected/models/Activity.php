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

    /**
     * Generates an array of all records
     *
	 * @param $columnOrder string Optional column order to pass to query
     *
     * @return $listResults array List of matched enytries
     * @access public
     */
    static public function getCollection($columnOrder = "activity_id")
    {

        // dependency query
        $dependencyQuery       = new CDbCacheDependency('SELECT MAX(activity_id) FROM tbl_activity');
        $listResults           = Yii::app()->db
                                    ->cache(Yii::app()->params['CACHE_EXPIRY_LOOKUP_DATA'], $dependencyQuery)
                                    ->createCommand()
                                    ->select("*")
                                    ->order($columnOrder)
                                    ->from('tbl_activity')
                                    ->queryAll();

        return $listResults;

    }

    /**
     * Generates an flattened list of actvities.  It does this by flattening the results set
	 * ...into a simple list
     *
     * @param $columnOrder string Optional column order to pass to query
     *
     * @return $listResults array List of matched enytries
     * @access public
     */
    static public function getFlattenedCollection()
    {

        // Specify the ID for the cache item we wish to reference
        $activityCacheId = 'flattened_activity_list';

        // Attempt to load the data from the cache, based on the key
        $activityData = false;
        $activityData = Yii::app()->cache->get($activityCacheId);

        // If the results were false, then we have no valid data, so load it

        $flattenedActivityList = array();

        /* IF the results are not cached, load it */
        if($activityData===false)
        {

            $activityList = self::getCollection();

            foreach ($activityList as $activityItem) {

                $flattenedActivityList[] = array('id'   => $activityItem['activity_id'],
                                                 'text' => $activityItem['keyword']);

                // Now explode the related word lists and add that to the list
                $relatedWordList = explode(",", $activityItem['related_words']);

                foreach ($relatedWordList as $relatedWord) {
                    $flattenedActivityList[] = array('id'   => $activityItem['activity_id'],
                                                     'text' => $relatedWord);
                }

            }

            /* Save the results to cache */
            Yii::app()->cache->set($activityCacheId, $flattenedActivityList, 10000);

            return $flattenedActivityList;
        }
        else {          // return the cached results
            return $activityData;
        }
    }


}
