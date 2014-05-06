<?php

/**
 * This is the model class for table "{{tn_event}}".
 *
 * The followings are the available columns in table '{{tn_event}}':
 * @property integer $tn_event_id
 * @property integer $tn_id
 * @property integer $tn_child_category_id
 * @property integer $tn_parent_category_id
 * @property integer $tn_grandchild_category_id
 * @property string $tn_city
 * @property integer $tn_state_id
 * @property string $tn_state_name
 * @property integer $tn_country_id
 * @property string $tn_date
 * @property string $tn_display_date
 * @property string $tn_interactive_map_url
 * @property string $tn_event_name
 * @property string $tn_venue
 * @property integer $tn_venue_id
 * @property integer $tn_venue_configuration_id
 */

 /**
 * TnEvent activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $event = TnEvent::model()
 * ...or
 * ...   $event = new TnEvent;
 * ...or
 * ...   $event = new TnEvent($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class TnEvent extends CActiveRecord
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
		return '{{tn_event}}';
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
			array('tn_id',                                       'required'),
			array('tn_id, tn_child_category_id, tn_parent_category_id,
			       tn_grandchild_category_id, tn_state_id, tn_country_id,
			       tn_venue_id, tn_venue_configuration_id',      'numerical', 'integerOnly'=>true),
			array('tn_city, tn_state_name, tn_date, tn_display_date,tn_venue', 'length', 'max'=>255),
			array('tn_interactive_map_url, tn_event_name', 'length', 'max'=>512),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('tn_event_id, tn_id, tn_child_category_id, tn_parent_category_id, tn_grandchild_category_id, tn_city, tn_state_id, tn_state_name, tn_country_id, tn_date, tn_display_date, tn_interactive_map_url, tn_event_name, tn_venue, tn_venue_id, tn_venue_configuration_id', 'safe', 'on'=>'search'),
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
			'tn_event_id'                => 'Ticket Network Event',
			'tn_id'                      => 'Tn',
			'tn_child_category_id'       => 'Ticket Network Child Category',
			'tn_parent_category_id'      => 'Ticket Network Parent Category',
			'tn_grandchild_category_id'  => 'Ticket Network Grandchild Category',
			'tn_city'                    => 'Ticket Network City',
			'tn_state_id'                => 'Ticket Network State',
			'tn_state_name'              => 'Ticket Network State Name',
			'tn_country_id'              => 'Ticket Network Country',
			'tn_date'                    => 'Ticket Network Date',
			'tn_display_date'            => 'Ticket Network Display Date',
			'tn_interactive_map_url'     => 'Ticket Network Interactive Map Url',
			'tn_event_name'              => 'Ticket Network Event Name',
			'tn_venue'                   => 'Ticket Network Venue',
			'tn_venue_configuration_id'  => 'Ticket Network Venue Configuration',
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

		$criteria->compare('tn_event_id',                 $this->tn_event_id);
		$criteria->compare('tn_id',                       $this->tn_id);
		$criteria->compare('tn_child_category_id',        $this->tn_child_category_id);
		$criteria->compare('tn_parent_category_id',       $this->tn_parent_category_id);
		$criteria->compare('tn_grandchild_category_id',   $this->tn_grandchild_category_id);
		$criteria->compare('tn_city',                     $this->tn_city,true);
		$criteria->compare('tn_state_id',                 $this->tn_state_id);
		$criteria->compare('tn_state_name',               $this->tn_state_name,true);
		$criteria->compare('tn_country_id',               $this->tn_country_id);
		$criteria->compare('tn_date',                     $this->tn_date,true);
		$criteria->compare('tn_display_date',             $this->tn_display_date,true);
		$criteria->compare('tn_interactive_map_url',      $this->tn_interactive_map_url,true);
		$criteria->compare('tn_event_name',               $this->tn_event_name,true);
		$criteria->compare('tn_venue',                    $this->tn_venue,true);
		$criteria->compare('tn_venue_id',                 $this->tn_venue_id);
		$criteria->compare('tn_venue_configuration_id',   $this->tn_venue_configuration_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return TnEvent the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
