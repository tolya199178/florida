<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $banner_id
 * @property integer $business_id
 * @property string $banner_title
 * @property string $banner_description
 * @property string $banner_url
 * @property string $banner_expiry
 * @property string $banner_photo
 * @property string $banner_status
 * @property integer $banner_view_limit
 * @property integer $banner_views
 * @property integer $banner_clicks
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $createdBy
 * @property User $modifiedBy
 * @property BannerPage[] $bannerPages
 */

 /**
 * Banner activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $banner = Banner::model()
 * ...or
 * ...   $banner = new Banner;
 * ...or
 * ...   $banner = new Banner($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class Banner extends CActiveRecord
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
		return '{{banner}}';
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
			array('business_id, banner_title, banner_url',                   'required'),

		    // Data type and length validations
		    array('business_id, banner_view_limit, banner_views,
			       banner_clicks', 'numerical',                              'integerOnly'=>true),
			array('banner_title, banner_url',                                'length', 'max'=>255),
			array('banner_description',                                      'length', 'max'=>4096),
			array('banner_photo',                                            'length', 'max'=>1024),
		    array('banner_expiry',                                           'length', 'max'=>1024),

		    // Ranges
		    array('banner_status',
		          'in', 'range'=>array('Active','Inactive'), 'allowEmpty'=>false),

		    // Form only attributes.
		    array('fldUploadImage',
		          'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty'=>true),


            // The following rule is used by search(). It only contains attributes that should be searched.
			array('banner_id, business_id, banner_title, banner_description, banner_url, banner_expiry, banner_photo, banner_status, banner_view_limit, banner_views, banner_clicks, created_time, modified_time, created_by, modified_by', 'safe', 'on'=>'search'),
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
			'business'           => array(self::BELONGS_TO, 'Business',   'business_id'),
			'createdBy'          => array(self::BELONGS_TO, 'User',       'created_by'),
			'modifiedBy'         => array(self::BELONGS_TO, 'User',       'modified_by'),
			'bannerPages'        => array(self::HAS_MANY,   'BannerPage', 'banner_id'),
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
			'banner_id'              => 'Banner',
			'business_id'            => 'Business',
			'banner_title'           => 'Banner Title',
			'banner_description'     => 'Banner Description',
			'banner_url'             => 'Banner Url',
			'banner_expiry'          => 'Banner Expiry',
			'banner_photo'           => 'Banner Photo',
			'banner_status'          => 'Banner Status',
			'banner_view_limit'      => 'Banner View Limit',
			'banner_views'           => 'Banner Views',
			'banner_clicks'          => 'Banner Clicks',
			'created_time'           => 'Created Time',
			'modified_time'          => 'Modified Time',
			'created_by'             => 'Created By',
			'modified_by'            => 'Modified By',
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

		$criteria->compare('banner_id',           $this->banner_id);
		$criteria->compare('business_id',         $this->business_id);
		$criteria->compare('banner_title',        $this->banner_title,true);
		$criteria->compare('banner_description',  $this->banner_description,true);
		$criteria->compare('banner_url',          $this->banner_url,true);
		$criteria->compare('banner_expiry',       $this->banner_expiry,true);
		$criteria->compare('banner_photo',        $this->banner_photo,true);
		$criteria->compare('banner_status',       $this->banner_status,true);
		$criteria->compare('banner_view_limit',   $this->banner_view_limit);
		$criteria->compare('banner_views',        $this->banner_views);
		$criteria->compare('banner_clicks',       $this->banner_clicks);
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
     * @return Banner the static model class
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

}
