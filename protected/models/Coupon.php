<?php

/**
 * This is the model class for table "{{coupon}}".
 *
 * The followings are the available columns in table '{{coupon}}':
 * @property integer $coupon_id
 * @property integer $business_id
 * @property string $coupon_name
 * @property integer $count_created
 * @property string integer $count_available
 * @property string $coupon_expiry
 * @property string $coupon_photo
 * @property string $coupon_description
 * @property string $terms
 * @property string $printed
 * @property string $coupon_value
 * @property string $coupon_value_type
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $createdBy
 * @property User $modifiedBy
 * @property CouponPrintLog[] $couponPrintLogs
 */

 /**
 * Coupon activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $coupon = Coupon::model()
 * ...or
 * ...   $coupon = new Coupon;
 * ...or
 * ...   $coupon = new Coupon($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class Coupon extends CActiveRecord
{

    /**
     *
     * @var string fldUploadImage Business image uploader.
     * @access public
     */
    public $fldUploadImage;

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
		return '{{coupon}}';
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
			array('business_id, coupon_name, count_available',           'required'),

		    // Data types, sizes
			array('business_id, count_created, count_available',         'numerical', 'integerOnly'=>true),
			array('coupon_name', 'length',                               'max'=>250),
		    array('coupon_photo', 'length',                              'max'=>1024),
		    array('coupon_description, terms',                           'length', 'max'=>4096),

		    array('coupon_expiry',                                       'length', 'max'=>32),
		    array('coupon_value',                                        'length', 'max'=>10),

		    // ranges
		    array('coupon_value_type',
		          'in', 'range'=>array('%','$'),'allowEmpty'=>true),
		    array('printed',
		          'in', 'range'=>array('Y','N'),'allowEmpty'=>false),

		    // Form only attributes.
		    array('fldUploadImage',                       'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),


            // The following rule is used by search(). It only contains attributes that should be searched.
            array('coupon_id, business_id, coupon_name, count_created, count_available, coupon_expiry, coupon_photo, coupon_description, terms, printed, coupon_value, coupon_value_type, created_time, modified_time, created_by, modified_by', 'safe', 'on'=>'search'),
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
			'business'           => array(self::BELONGS_TO, 'Business', 'business_id'),
			'createdBy'          => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy'         => array(self::BELONGS_TO, 'User', 'modified_by'),
		    'couponPrintLogs'    => array(self::HAS_MANY,   'CouponPrintLog', 'coupon_id'),
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
			'coupon_id'              => 'Coupon',
			'business_id'            => 'Business',
			'coupon_name'            => 'Coupon Name',
			'count_created'          => 'Count Created',
			'count_available'        => 'Count Available',
			'coupon_expiry'          => 'Coupon Expiry Date',
			'coupon_photo'           => 'Coupon Photo',
			'coupon_description'     => 'Coupon Description',
			'terms'                  => 'Terms',
			'printed'                => 'Printed',
			'coupon_value'           => 'Coupon Value',
			'coupon_value_type'      => 'Coupon Value Type',
			'created_time'           => 'Created Time',
			'modified_time'          => 'Modified Time',
			'created_by'             => 'Created By',
			'modified_by'            => 'Modified By',
		    'fldCouponCreateCount'   => '#Coupons to be Issued'
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

		$criteria->compare('coupon_id',           $this->coupon_id);
		$criteria->compare('business_id',         $this->business_id);
		$criteria->compare('coupon_name',         $this->coupon_name,true);
		$criteria->compare('count_created',       $this->count_created);
		$criteria->compare('count_available',     $this->count_available);
		$criteria->compare('coupon_expiry',       $this->coupon_expiry,true);
		$criteria->compare('coupon_photo',        $this->coupon_photo,true);
		$criteria->compare('coupon_description',  $this->coupon_description,true);
		$criteria->compare('terms',               $this->terms,true);
		$criteria->compare('printed',             $this->printed,true);
		$criteria->compare('coupon_value',        $this->coupon_value,true);
		$criteria->compare('coupon_value_type',   $this->coupon_value_type,true);
		$criteria->compare('created_time',        $this->created_time,true);
		$criteria->compare('modified_time',       $this->modified_time,true);
		$criteria->compare('created_by',          $this->created_by);
		$criteria->compare('modified_by',         $this->modified_by);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Coupon the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Runs just before the models save method is invoked. It provides a change to
	 * ...further prepare the data for saving. The CActiveRecord (parent class)
	 * ...beforeSave is called to process any raised events.
	 *
	 * @param <none> <none>
	 * @return boolean the decision to continue the save or not.
	 *
	 * @access public
	 */
	public function beforeSave() {

	    // /////////////////////////////////////////////////////////////////
	    // Set the create time and user for new records
	    // /////////////////////////////////////////////////////////////////
	    if ($this->isNewRecord) {
	        $this->created_time = new CDbExpression('NOW()');
	        $this->created_by   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
	    }

	    // /////////////////////////////////////////////////////////////////
	    // The modified log details is set for record creation and update
	    // /////////////////////////////////////////////////////////////////
	    $this->modified_time = new CDbExpression('NOW()');
	    $this->modified_by   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);

	    return parent::beforeSave();
	}

	/**
	 * Build an associative list of coupon type values.
	 *
	 * @param <none> <none>
	 * @return array associatve list of user type values
	 *
	 * @access public
	 */
	public function listCouponTypes() {

	    return array('Unique'      => 'Unique',
	                 'Generic'     => 'Generic',
	           );
	}

}
