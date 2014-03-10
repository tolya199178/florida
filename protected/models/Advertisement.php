<?php

/**
 * This is the model class for table "{{advertisement}}".
 *
 * The followings are the available columns in table '{{advertisement}}':
 * @property integer $advertisement_id
 * @property string $advert_type
 * @property string $title
 * @property string $content
 * @property string $image
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $published
 * @property string $publish_date
 * @property string $expiry_date
 * @property integer $user_id
 * @property double $maximum_ads_views
 * @property double $maximum_ads_clicks
 * @property double $ads_views
 * @property double $ads_clicks
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $createdBy
 * @property User $modifiedBy
 */

/**
 * Advertisement activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $advertisement = Advertisement::model()
 * ...or
 * ...   $advertisement = new Advertisement;
 * ...or
 * ...   $advertisement = new Advertisement($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Advertisement extends CActiveRecord
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
		return '{{advertisement}}';
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
			array('content',                      'required'),
		    
		    // Data types, sizes
			array('user_id, maximum_ads_views,
			       maximum_ads_clicks, ads_views,
			       ads_clicks',                   'numerical'),
		    array('title',                        'length', 'max'=>255),
		    
		    // ranges
			array('advert_type',                  'in', 'range'=>array('Google','Custom','Any')),
		    array('published',                    'in','range'=>array('Y','N'),'allowEmpty'=>false),
		    
		    // Safe
		    array('image, expiry_date',           'safe'),

		    // The following rule is used by search(). It only contains attributes that should be searched.
			array('advertisement_id, advert_type,
			       title, content, created_time,
			       modified_time, created_by, 
			       modified_by, published, publish_date, 
			       expiry_date, user_id, maximum_ads_views,
			       maximum_ads_clicks, ads_views,
			       ads_clicks',                   'safe', 'on'=>'search'),
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
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
			'createdBy'  => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy' => array(self::BELONGS_TO, 'User', 'modified_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'advertisement_id'   => 'Advertisement',
			'advert_type'        => 'Advert Type',
			'title'              => 'Title',
			'content'            => 'Content',
			'image'              => 'Image',
			'created_time'       => 'Created Time',
			'modified_time'      => 'Modified Time',
			'created_by'         => 'Created By',
			'modified_by'        => 'Modified By',
			'published'          => 'Published',
			'publish_date'       => 'Publish Date',
			'expiry_date'        => 'Expiry Date',
			'user_id'            => 'User',
			'maximum_ads_views'  => 'Maximum Ads Views',
			'maximum_ads_clicks' => 'Maximum Ads Clicks',
			'ads_views'          => 'Ads Views',
			'ads_clicks'         => 'Ads Clicks',
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
     */s
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('advertisement_id',    $this->advertisement_id);
		$criteria->compare('advert_type',         $this->advert_type,true);
		$criteria->compare('title',               $this->title,true);
		$criteria->compare('content',             $this->content,true);
		$criteria->compare('created_time',        $this->created_time,true);
		$criteria->compare('modified_time',       $this->modified_time,true);
		$criteria->compare('created_by',          $this->created_by);
		$criteria->compare('modified_by',         $this->modified_by);
		$criteria->compare('published',           $this->published,true);
		$criteria->compare('publish_date',        $this->publish_date,true);
		$criteria->compare('expiry_date',         $this->expiry_date,true);
		$criteria->compare('user_id',             $this->user_id);
		$criteria->compare('maximum_ads_views',   $this->maximum_ads_views);
		$criteria->compare('maximum_ads_clicks',  $this->maximum_ads_clicks);
		$criteria->compare('ads_views',           $this->ads_views);
		$criteria->compare('ads_clicks',          $this->ads_clicks);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Advertisement the static model class
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
	        $this->created_by   = Yii::app()->user->id;
	    }
	    
	    // /////////////////////////////////////////////////////////////////
	    // The modified log details is set for record creation and update
	    // /////////////////////////////////////////////////////////////////
	    $this->modified_time = new CDbExpression('NOW()');
	    $this->modified_by   = Yii::app()->user->id;

	
	    return parent::beforeSave();
	}
}
