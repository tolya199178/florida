<?php

/**
 * This is the model class for table "{{mobile_carrier}}".
 *
 * The followings are the available columns in table '{{mobile_carrier}}':
 * @property integer $mobile_carrier_id
 * @property string $mobile_carrier_name
 * @property string $can_send
 * @property string $recipient_address
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property User[] $users
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $mobile_carrier = MobileCarrier::model()
 * ...or
 * ...   $mobile_carrier = new MobileCarrier;
 * ...or
 * ...   $mobile_carrier = new MobileCarrier($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class MobileCarrier extends CActiveRecord
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
		return '{{mobile_carrier}}';
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
			array('mobile_carrier_name', 'required'),

		    // Data types, sizes
			array('mobile_carrier_name', 'length', 'max'=>255),
		    array('recipient_address',   'length', 'max'=>255),
		    array('can_send',            'in','range'=>array('Y','N'),'allowEmpty'=>true),
		    array('notes',               'length', 'max'=>255),


            // The following rule is used by search(). It only contains attributes that should be searched.
			array('mobile_carrier_id, mobile_carrier_name, can_send, recipient_address', 'safe', 'on'=>'search'),
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
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'users' => array(self::HAS_MANY, 'User', 'mobile_carrier_id'),
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
			'mobile_carrier_id' 	=> 'Mobile Carrier',
			'mobile_carrier_name' 	=> 'Mobile Carrier Name',
		    'can_send'              => 'Can Send',
		    'recipient_address'     => 'Recipient Address',
		    'notes'                 => 'Notes',
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

		$criteria->compare('mobile_carrier_id',		$this->mobile_carrier_id);
		$criteria->compare('mobile_carrier_name',	$this->mobile_carrier_name,true);
		$criteria->compare('can_send',              $this->can_send);
		$criteria->compare('recipient_address',     $this->recipient_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MobileCarrier the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
