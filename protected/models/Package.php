<?php

/**
 * This is the model class for table "{{package}}".
 *
 * The followings are the available columns in table '{{package}}':
 * @property integer $package_id
 * @property string $package_name
 * @property string $package_image
 * @property string $package_description
 * @property integer $package_expire
 * @property string $package_price
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property PackageItems[] $packageItems
 */

 /**
 * Package activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = Package::model()
 * ...or
 * ...   $model = new Package;
 * ...or
 * ...   $model = new Package($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class Package extends CActiveRecord
{

    /**
     *
     * @var string fldUploadImage advert image uploader.
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
		return '{{package}}';
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
			array('package_name, package_price', 'required'),
			array('package_expire', 'numerical', 'integerOnly'=>true),
			array('package_name', 'length', 'max'=>250),
			array('package_price', 'length', 'max'=>10),
			array('package_image, package_description', 'safe'),

            // Form only attributes.
		    array('fldUploadImage',               'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('package_id, package_name, package_image, package_description, package_expire, package_price, created_time', 'safe', 'on'=>'search'),
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
		    'modifiedBy'      => array(self::BELONGS_TO, 'User', 'modified_by'),
		    'createdBy'       => array(self::BELONGS_TO, 'User', 'created_by'),
			'packageItems'    => array(self::HAS_MANY, 'PackageItem', 'package_id'),
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
			'package_id'         => 'Package',
			'package_name'       => 'Package Name',
			'package_image'      => 'Package Image',
			'package_description'=> 'Package Description',
			'package_expire'     => 'Package Expire (months)',
			'package_price'      => 'Package Price',
			'created_time'       => 'Created Time',
		    'modified_time'      => 'Modified Time',
		    'created_by'         => 'Created By',
		    'modified_by'        => 'Modified By',
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

		$criteria->compare('package_id',          $this->package_id);
		$criteria->compare('package_name',        $this->package_name,true);
		$criteria->compare('package_image',       $this->package_image,true);
		$criteria->compare('package_description', $this->package_description,true);
		$criteria->compare('package_expire',      $this->package_expire);
		$criteria->compare('package_price',       $this->package_price,true);
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
     * @return Package the static model class
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
	 * Build an associative list of event type values.
	 *
	 * @param <none> <none>
	 * @return array associatve list of permission status values
	 *
	 * @access public
	 */
	public function listExpiryPeriods()
	{

	    return array('30' =>'1 Month (30 days)',
	                 '90' =>'3 Months (90 days)',
	                 '180' => '6 Months (180 days)',
	                 '365' => '12 Months (365 days)');
	}

}
