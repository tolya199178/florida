<?php

/**
 * This is the model class for table "{{my_package_item}}".
 *
 * The followings are the available columns in table '{{my_package_item}}':
 * @property integer $my_package_item_id
 * @property integer $my_package_id
 * @property integer $item_type_id
 * @property integer $quantity
 *
 * The followings are the available model relations:
 * @property PackageItemType $itemType
 * @property MyPackage $myPackage
 */

 /**
 * MyPackageItem activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = MyPackageItem::model()
 * ...or
 * ...   $model = new MyPackageItem;
 * ...or
 * ...   $model = new MyPackageItem($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class MyPackageItem extends CActiveRecord
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
		return '{{my_package_item}}';
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
			array('my_package_id, item_type_id, quantity', 'required'),
			array('my_package_id, item_type_id, quantity', 'numerical', 'integerOnly'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('my_package_item_id, my_package_id, item_type_id, quantity', 'safe', 'on'=>'search'),
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
			'itemType'      => array(self::BELONGS_TO, 'PackageItemType', 'item_type_id'),
			'myPackage'      => array(self::BELONGS_TO, 'MyPackage', 'my_package_id'),
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
			'my_package_item_id'      => 'My Package Item',
			'my_package_id'      => 'My Package',
			'item_type_id'      => 'Item Type',
			'quantity'      => 'Quantity',
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

		$criteria->compare('my_package_item_id',$this->my_package_item_id);
		$criteria->compare('my_package_id',$this->my_package_id);
		$criteria->compare('item_type_id',$this->item_type_id);
		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MyPackageItem the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
