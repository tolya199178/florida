<?php

/**
 * This is the model class for table "{{business_user}}".
 *
 * The followings are the available columns in table '{{business_user}}':
 * @property integer $business_user_id
 * @property integer $business_id
 * @property integer $user_id
 * @property string $primary_user
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
 * ...   $business_user = BusinessUser::model()
 * ...or
 * ...   $business_user = new BusinessUser;
 * ...or
 * ...   $business_user = new BusinessUser($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class BusinessUser extends CActiveRecord
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
		return '{{business_user}}';
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
		    
		    // ranges
			array('primary_user',                'in','range'=>array('Y','N'),'allowEmpty'=>false),
		    
            // The following rule is used by search(). It only contains attributes that should be searched.
			array('business_user_id, business_id, 
			       user_id, primary_user',       'safe', 'on'=>'search'),
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
			'business_user_id'   => 'Business User',
			'business_id'        => 'Business',
			'user_id'            => 'User',
			'primary_user'       => 'Primary User',
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

		$criteria->compare('business_user_id',    $this->business_user_id);
		$criteria->compare('business_id',         $this->business_id);
		$criteria->compare('user_id',             $this->user_id);
		$criteria->compare('primary_user',        $this->primary_user, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return BusinessUser the static model class
     * 
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
