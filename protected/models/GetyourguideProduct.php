<?php

/**
 * This is the model class for table "getyourguide_product".
 *
 * The followings are the available columns in table 'getyourguide_product':
 * @property string $product_id
 * @property integer $gyg_id
 * @property string $gyg_last_modify_time
 * @property string $gyg_title
 * @property string $gyg_abstract
 * @property string $gyg_destination_list
 * @property string $gyg_price
 * @property string $gyg_price_description
 * @property string $gyg_rating
 * @property string $gyg_url
 * @property string $gyg_language
 */

 /**
 * GetyourguideProduct activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $tour = GetyourguideProduct::model()
 * ...or
 * ...   $tour = new GetyourguideProduct;
 * ...or
 * ...   $tour = new GetyourguideProduct($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class GetyourguideProduct extends CActiveRecord
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
		return '{{getyourguide_product}}';
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
			array('gyg_id',                                      'required'),
			array('gyg_id',                                      'numerical', 'integerOnly'=>true),
			array('gyg_title, gyg_destination_list',             'length', 'max'=>1024),
			array('gyg_price, gyg_price_description, gyg_url',   'length', 'max'=>255),
			array('gyg_rating',                                  'length', 'max'=>16),
			array('gyg_language',                                'length', 'max'=>32),
			array('gyg_abstract',                                'length', 'max'=>4096),
		    array('gyg_last_modify_time',                        'length', 'max'=>64),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('product_id, gyg_id, gyg_last_modify_time, gyg_title, gyg_abstract, gyg_price, gyg_price_description, gyg_rating, gyg_url, gyg_language', 'safe', 'on'=>'search'),
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
			'product_id'                 => 'Product',
			'gyg_id'                     => 'Gyg',
			'gyg_last_modify_time'       => 'Gyg Last Modify Time',
			'gyg_title'                  => 'Gyg Title',
			'gyg_abstract'               => 'Gyg Abstract',
			'gyg_destination_list'       => 'Gyg Destination List',
			'gyg_price'                  => 'Gyg Price',
			'gyg_price_description'      => 'Gyg Price Description',
			'gyg_rating'                 => 'Gyg Rating',
			'gyg_url'                    => 'Gyg Url',
			'gyg_language'               => 'Gyg Language',
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

		$criteria->compare('product_id',              $this->product_id,true);
		$criteria->compare('gyg_id',                  $this->gyg_id);
		$criteria->compare('gyg_last_modify_time',    $this->gyg_last_modify_time,true);
		$criteria->compare('gyg_title',               $this->gyg_title,true);
		$criteria->compare('gyg_abstract',            $this->gyg_abstract,true);
		$criteria->compare('gyg_price_description',   $this->gyg_price_description,true);
		$criteria->compare('gyg_rating',              $this->gyg_rating,true);
		$criteria->compare('gyg_url',                 $this->gyg_url,true);
		$criteria->compare('gyg_language',            $this->gyg_language,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return GetyourguideProduct the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
