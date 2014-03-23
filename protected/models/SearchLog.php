<?php

/**
 * This is the model class for table "{{search_log}}".
 *
 * The followings are the available columns in table '{{search_log}}':
 * @property integer $search_id
 * @property string $search_origin
 * @property string $search_details
 * @property integer $search_count
 */
/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $search = SearchLog::model()
 * ...or
 * ...   $search = new SearchLog;
 * ...or
 * ...   $search = new SearchLog($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class SearchLog extends CActiveRecord
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
		return '{{search_log}}';
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

		$criteria = new CDbCriteria;

		$criteria->compare('search_id',       $this->search_id);
		$criteria->compare('search_origin',   $this->search_origin,true);
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
     * @return SearchLog the static model class
     * 
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
