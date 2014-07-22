<?php

/**
 * This is the model class for table "{{my_package}}".
 *
 * The followings are the available columns in table '{{my_package}}':
 * @property integer $my_package_id
 * @property integer $package_id
 * @property integer $business_id
 * @property string $created_time
 * @property string $expire_time
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property Package $package
 * @property MyPackageItem[] $myPackageItems
 */

 /**
 * MyPackage activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = MyPackage::model()
 * ...or
 * ...   $model = new MyPackage;
 * ...or
 * ...   $model = new MyPackage($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class MyPackage extends CActiveRecord
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
		return '{{my_package}}';
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
			array('package_id, business_id', 'required'),
			array('package_id, business_id', 'numerical', 'integerOnly'=>true),
			array('expire_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('my_package_id, package_id, business_id, created_time, expire_time', 'safe', 'on'=>'search'),
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
			'business'      => array(self::BELONGS_TO, 'Business', 'business_id'),
			'package'      => array(self::BELONGS_TO, 'Package', 'package_id'),
			'myPackageItems'      => array(self::HAS_MANY, 'MyPackageItem', 'my_package_id'),
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
			'my_package_id'      => 'My Package',
			'package_id'      => 'Package',
			'business_id'      => 'Business',
			'created_time'      => 'Created Time',
			'expire_time'      => 'Expire Time',
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

		$criteria->compare('my_package_id',$this->my_package_id);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('expire_time',$this->expire_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function beforeSave() {
        // /////////////////////////////////////////////////////////////////
	    // Set the create time and user for new records
	    // /////////////////////////////////////////////////////////////////
	    if ($this->isNewRecord) {
	        $this->created_time = new CDbExpression('NOW()');
	    }

        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MyPackage the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
