<?php

/**
 * This is the model class for table "tbl_restaurant_certificate_purchases".
 *
 * The followings are the available columns in table 'restaurante_certificate_purchases':
 * @property integer $purchase_id
 * @property integer $user_id
 * @property integer $business_id
 * @property integer $count
 * @property double $totalcost
 * @property string $status
 * @property integer $deliveredcount
 * @property integer $created_time
 * @property integer $approved_time
 */

 /**
 * RestauranteCertificatePurchase activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = RestauranteCertificatePurchase::model()
 * ...or
 * ...   $model = new RestauranteCertificatePurchase;
 * ...or
 * ...   $model = new RestauranteCertificatePurchase($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class RestaurantCertificatePurchase extends CActiveRecord
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
		return 'tbl_restaurant_certificate_purchases';
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
			array('user_id, business_id, count, totalcost, created_time', 'required'),
			array('user_id, business_id, count, deliveredcount', 'numerical', 'integerOnly'=>true),
//			array('created_time, approved_time', 'date'),
			array('totalcost', 'numerical'),
			array('status', 'length', 'max'=>8),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('purchase_id, user_id, business_id, count, totalcost, status, deliveredcount, created_time, approved_time', 'safe', 'on'=>'search'),
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
			'purchase_id'      => 'Purchase',
			'user_id'      => 'User',
			'business_id'      => 'Business',
			'count'      => 'Count',
			'totalcost'      => 'Totalcost',
			'status'      => 'Status',
			'deliveredcount'      => 'Deliveredcount',
			'created_time'      => 'Created Time',
			'approved_time'      => 'Approved Time',
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

		$criteria->compare('purchase_id',$this->purchase_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('business_id',$this->business_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('totalcost',$this->totalcost);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('deliveredcount',$this->deliveredcount);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('approved_time',$this->approved_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return RestauranteCertificatePurchase the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
