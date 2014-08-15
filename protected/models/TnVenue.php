<?php

/**
 * This is the model class for table "{{tn_venue}}".
 *
 * The followings are the available columns in table '{{tn_venue}}':
 * @property integer $tbl_tn_venue_id
 * @property integer $tn_ID
 * @property string $tn_Name
 * @property string $tn_Street1
 * @property string $tn_Street2
 * @property string $tn_StateProvince
 * @property string $tn_City
 * @property string $tn_Country
 * @property string $tn_BoxOfficePhone
 * @property string $tn_Directions
 * @property string $tn_Parking
 * @property string $tn_PublicTransportation
 * @property string $tn_URL
 * @property string $tn_ZipCode
 * @property string $tn_Capacity
 * @property string $tn_ChildRules
 * @property string $tn_Rules
 * @property string $tn_Notes
 * @property integer $tn_NumberOfConfigurations
 * @property string $WillCall
 */

 /**
 * TnVenue activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = TnVenue::model()
 * ...or
 * ...   $model = new TnVenue;
 * ...or
 * ...   $model = new TnVenue($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class TnVenue extends CActiveRecord
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
		return '{{tn_venue}}';
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
			array('tn_ID, tn_NumberOfConfigurations', 'numerical', 'integerOnly'=>true),
			array('tn_Name, tn_Street1, tn_Street2, tn_StateProvince, tn_City, tn_Country, tn_BoxOfficePhone, tn_Directions, tn_Parking, tn_PublicTransportation, tn_URL, tn_ZipCode, tn_Capacity, tn_ChildRules, tn_Rules, WillCall', 'length', 'max'=>255),
			array('tn_Notes', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('tbl_tn_venue_id, tn_ID, tn_Name, tn_Street1, tn_Street2, tn_StateProvince, tn_City, tn_Country, tn_BoxOfficePhone, tn_Directions, tn_Parking, tn_PublicTransportation, tn_URL, tn_ZipCode, tn_Capacity, tn_ChildRules, tn_Rules, tn_Notes, tn_NumberOfConfigurations, WillCall', 'safe', 'on'=>'search'),
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
			'tbl_tn_venue_id'      => 'Tbl Tn Venue',
			'tn_ID'      => 'Tn',
			'tn_Name'      => 'Tn Name',
			'tn_Street1'      => 'Tn Street1',
			'tn_Street2'      => 'Tn Street2',
			'tn_StateProvince'      => 'Tn State Province',
			'tn_City'      => 'Tn City',
			'tn_Country'      => 'Tn Country',
			'tn_BoxOfficePhone'      => 'Tn Box Office Phone',
			'tn_Directions'      => 'Tn Directions',
			'tn_Parking'      => 'Tn Parking',
			'tn_PublicTransportation'      => 'Tn Public Transportation',
			'tn_URL'      => 'Tn Url',
			'tn_ZipCode'      => 'Tn Zip Code',
			'tn_Capacity'      => 'Tn Capacity',
			'tn_ChildRules'      => 'Tn Child Rules',
			'tn_Rules'      => 'Tn Rules',
			'tn_Notes'      => 'Tn Notes',
			'tn_NumberOfConfigurations'      => 'Tn Number Of Configurations',
			'WillCall'      => 'Will Call',
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

		$criteria->compare('tbl_tn_venue_id',$this->tbl_tn_venue_id);
		$criteria->compare('tn_ID',$this->tn_ID);
		$criteria->compare('tn_Name',$this->tn_Name,true);
		$criteria->compare('tn_Street1',$this->tn_Street1,true);
		$criteria->compare('tn_Street2',$this->tn_Street2,true);
		$criteria->compare('tn_StateProvince',$this->tn_StateProvince,true);
		$criteria->compare('tn_City',$this->tn_City,true);
		$criteria->compare('tn_Country',$this->tn_Country,true);
		$criteria->compare('tn_BoxOfficePhone',$this->tn_BoxOfficePhone,true);
		$criteria->compare('tn_Directions',$this->tn_Directions,true);
		$criteria->compare('tn_Parking',$this->tn_Parking,true);
		$criteria->compare('tn_PublicTransportation',$this->tn_PublicTransportation,true);
		$criteria->compare('tn_URL',$this->tn_URL,true);
		$criteria->compare('tn_ZipCode',$this->tn_ZipCode,true);
		$criteria->compare('tn_Capacity',$this->tn_Capacity,true);
		$criteria->compare('tn_ChildRules',$this->tn_ChildRules,true);
		$criteria->compare('tn_Rules',$this->tn_Rules,true);
		$criteria->compare('tn_Notes',$this->tn_Notes,true);
		$criteria->compare('tn_NumberOfConfigurations',$this->tn_NumberOfConfigurations);
		$criteria->compare('WillCall',$this->WillCall,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return TnVenue the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
