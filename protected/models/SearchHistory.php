<?php

/**
 * This is the model class for table "{{search_history}}".
 *
 * The followings are the available columns in table '{{search_history}}':
 * @property integer $search_id
 * @property integer $user_id
 * @property integer $user_location
 * @property string $created_time
 * @property string $search_details
 *
 * The followings are the available model relations:
 * @property User $user
 */

 /**
 * SearchHistory activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $search = SearchHistory::model()
 * ...or
 * ...   $search = new SearchHistory;
 * ...or
 * ...   $search = new SearchHistory($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class SearchHistory extends CActiveRecord
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
		return '{{search_history}}';
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
		    // Mandatory fields
			array('created_time, search_details',    'required'),

		    // Data types, field lengths
			array('user_id, user_location',          'numerical', 'integerOnly'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('search_id, user_id, created_time', 'safe', 'on'=>'search'),
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
			'search_id'          => 'Search',
			'user_id'            => 'User',
			'user_location'      => 'User Location',
			'created_time'       => 'Created Time',
			'search_details'     => 'Search Details',
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

		$criteria->compare('search_id',       $this->search_id);
		$criteria->compare('user_id',         $this->user_id);
		$criteria->compare('user_location',   $this->user_location);
		$criteria->compare('created_time',    $this->created_time,true);
		$criteria->compare('search_details',  $this->search_details,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return SearchHistory the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
