<?php

/**
 * This is the model class for table "{{package_purchase}}".
 *
 * The followings are the available columns in table '{{package_purchase}}':
 * @property integer $package_purchase_id
 * @property integer $user_id
 * @property integer $business_id
 * @property string $status
 * @property double $total_cost
 * @property string $created_time
 * @property string $verified_time
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property Package $package
 * @property User $user
 */

 /**
 * PackagePurchase activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = PackagePurchase::model()
 * ...or
 * ...   $model = new PackagePurchase;
 * ...or
 * ...   $model = new PackagePurchase($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PackagePurchase extends CActiveRecord
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
		return '{{package_purchase}}';
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
			array('business_id, status, total_cost', 'required'),
			array('user_id, business_id', 'numerical', 'integerOnly'=>true),
			array('total_cost', 'numerical'),
			array('status', 'length', 'max'=>8),
			array('verified_time', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('package_purchase_id, user_id, business_id, status, total_cost, created_time, verified_time', 'safe', 'on'=>'search'),
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
			'user'      => array(self::BELONGS_TO, 'User', 'user_id'),
            'packages' => array(self::HAS_MANY, 'PackagePurchasePackage', 'package_purchase_id'),
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
			'package_purchase_id'      => 'Package Purchase',
			'user_id'      => 'User',
			'business_id'      => 'Business',
			'status'      => 'Status',
			'total_cost'      => 'Total Cost',
			'created_time'      => 'Created Time',
			'verified_time'      => 'Verified Time',
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

		$criteria->compare('package_purchase_id',$this->package_purchase_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('total_cost',$this->total_cost);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('verified_time',$this->verified_time,true);

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
	        $this->user_id   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
	    }

        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PackagePurchase the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
