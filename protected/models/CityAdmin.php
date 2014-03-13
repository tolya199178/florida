<?php

/**
 * This is the model class for table "{{city_admin}}".
 *
 * The followings are the available columns in table '{{city_admin}}':
 * @property integer $city_admin_id
 * @property integer $business_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $user
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $city_admin = CityAdmin::model()
 * ...or
 * ...   $city_admin = new CityAdmin;
 * ...or
 * ...   $city_admin = new CityAdmin($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class CityAdmin extends CActiveRecord
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
		return '{{city_admin}}';
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
			array('business_id, user_id',        'required'),
		    
		    // Data types, sizes
			array('business_id, user_id',        'numerical', 'integerOnly'=>true),
		    		    
            // The following rule is used by search(). It only contains attributes that should be searched.
			array('city_admin_id, business_id, user_id', 'safe', 'on'=>'search'),
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
			'business'   => array(self::BELONGS_TO, 'Business', 'business_id'),
			'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'city_admin_id'   => 'Business User',
			'business_id'        => 'Business',
			'user_id'            => 'User',
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

		$criteria->compare('city_admin_id',       $this->city_admin_id);
		$criteria->compare('business_id',         $this->business_id);
		$criteria->compare('user_id',             $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return CityAdmin the static model class
     * 
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
