<?php

/**
 * This is the model class for table "{{tn_venue_configuration}}".
 *
 * The followings are the available columns in table '{{tn_venue_configuration}}':
 * @property integer $tbl_tn_configuration_id
 * @property integer $tn_ID
 * @property string $tn_Capacity
 * @property string $tn_MapSite
 * @property string $tn_MapURL
 * @property string $tn_TypeDescription
 * @property string $tn_TypeID
 * @property string $tn_VenueID
 */

 /**
 * TnImportVenueConfiguration activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = TnImportVenueConfiguration::model()
 * ...or
 * ...   $model = new TnImportVenueConfiguration;
 * ...or
 * ...   $model = new TnImportVenueConfiguration($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class TnImportVenueConfiguration extends CActiveRecord
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
		return '{{tn_venue_configuration}}';
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
			array('tn_ID', 'numerical', 'integerOnly'=>true),
			array('tn_Capacity, tn_MapSite, tn_MapURL, tn_TypeDescription, tn_TypeID, tn_VenueID', 'length', 'max'=>255),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('tbl_tn_configuration_id, tn_ID, tn_Capacity, tn_MapSite, tn_MapURL, tn_TypeDescription, tn_TypeID, tn_VenueID', 'safe', 'on'=>'search'),
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
			'tbl_tn_configuration_id'      => 'Tbl Tn Configuration',
			'tn_ID'      => 'Tn',
			'tn_Capacity'      => 'Tn Capacity',
			'tn_MapSite'      => 'Tn Map Site',
			'tn_MapURL'      => 'Tn Map Url',
			'tn_TypeDescription'      => 'Tn Type Description',
			'tn_TypeID'      => 'Tn Type',
			'tn_VenueID'      => 'Tn Venue',
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

		$criteria->compare('tbl_tn_configuration_id',$this->tbl_tn_configuration_id);
		$criteria->compare('tn_ID',$this->tn_ID);
		$criteria->compare('tn_Capacity',$this->tn_Capacity,true);
		$criteria->compare('tn_MapSite',$this->tn_MapSite,true);
		$criteria->compare('tn_MapURL',$this->tn_MapURL,true);
		$criteria->compare('tn_TypeDescription',$this->tn_TypeDescription,true);
		$criteria->compare('tn_TypeID',$this->tn_TypeID,true);
		$criteria->compare('tn_VenueID',$this->tn_VenueID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return TnImportVenueConfiguration the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
