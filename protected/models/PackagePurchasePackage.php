<?php

/**
 * This is the model class for table "{{package_purchase_package}}".
 *
 * The followings are the available columns in table '{{package_purchase_package}}':
 * @property integer $package_puschase_package_id
 * @property integer $package_purchase_id
 * @property integer $package_id
 *
 * The followings are the available model relations:
 * @property Package $package
 * @property PackagePurchase $packagePurchase
 */

 /**
 * PackagePurchasePackage activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = PackagePurchasePackage::model()
 * ...or
 * ...   $model = new PackagePurchasePackage;
 * ...or
 * ...   $model = new PackagePurchasePackage($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PackagePurchasePackage extends CActiveRecord
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
		return '{{package_purchase_package}}';
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
			array('package_purchase_id, package_id', 'required'),
			array('package_purchase_id, package_id', 'numerical', 'integerOnly'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('package_puschase_package_id, package_purchase_id, package_id', 'safe', 'on'=>'search'),
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
			'package'      => array(self::BELONGS_TO, 'Package', 'package_id'),
			'packagePurchase'      => array(self::BELONGS_TO, 'PackagePurchase', 'package_purchase_id'),
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
			'package_puschase_package_id'      => 'Package Puschase Package',
			'package_purchase_id'      => 'Package Purchase',
			'package_id'      => 'Package',
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

		$criteria->compare('package_puschase_package_id',$this->package_puschase_package_id);
		$criteria->compare('package_purchase_id',$this->package_purchase_id);
		$criteria->compare('package_id',$this->package_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PackagePurchasePackage the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
