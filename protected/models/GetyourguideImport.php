<?php

/**
 * This is the model class for table "getyourguide_import".
 *
 * The followings are the available columns in table 'getyourguide_import':
 * @property integer $getyourguide_external_id
 * @property string $last_modification_datetime
 * @property string $title
 * @property string $abstract
 * @property string $categories
 * @property string $destination
 * @property string $price
 * @property string $prices_description
 * @property string $rating
 * @property string $pictures
 * @property string $url
 * @property string $language
 * @property string $record_id
 * @property string $source_filename
 * @property string $date_created
 * @property string $import_date
 * @property string $sync_date
 * @property string $import_comment
 * @property string $sync_comment
 */

 /**
 * GetyourguideImport activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = GetyourguideImport::model()
 * ...or
 * ...   $model = new GetyourguideImport;
 * ...or
 * ...   $model = new GetyourguideImport($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class GetyourguideImport extends CActiveRecord
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
		return 'getyourguide_import';
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
			array('getyourguide_external_id, date_created', 'required'),
			array('getyourguide_external_id', 'numerical', 'integerOnly'=>true),
			array('last_modification_datetime', 'length', 'max'=>64),
			array('title, price', 'length', 'max'=>1024),
			array('prices_description, source_filename', 'length', 'max'=>255),
			array('rating', 'length', 'max'=>16),
			array('url, language', 'length', 'max'=>32),
			array('abstract, categories, destination, pictures, import_date, sync_date, import_comment, sync_comment', 'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('getyourguide_external_id, last_modification_datetime, title, abstract, categories, destination, price, prices_description, rating, pictures, url, language, record_id, source_filename, date_created, import_date, sync_date, import_comment, sync_comment', 'safe', 'on'=>'search'),
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
			'getyourguide_external_id'      => 'Getyourguide External',
			'last_modification_datetime'      => 'Last Modification Datetime',
			'title'      => 'Title',
			'abstract'      => 'Abstract',
			'categories'      => 'Categories',
			'destination'      => 'Destination',
			'price'      => 'Price',
			'prices_description'      => 'Prices Description',
			'rating'      => 'Rating',
			'pictures'      => 'Pictures',
			'url'      => 'Url',
			'language'      => 'Language',
			'record_id'      => 'Record',
			'source_filename'      => 'Source Filename',
			'date_created'      => 'Date Created',
			'import_date'      => 'Import Date',
			'sync_date'      => 'Sync Date',
			'import_comment'      => 'Import Comment',
			'sync_comment'      => 'Sync Comment',
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

		$criteria->compare('getyourguide_external_id',$this->getyourguide_external_id);
		$criteria->compare('last_modification_datetime',$this->last_modification_datetime,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('abstract',$this->abstract,true);
		$criteria->compare('categories',$this->categories,true);
		$criteria->compare('destination',$this->destination,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('prices_description',$this->prices_description,true);
		$criteria->compare('rating',$this->rating,true);
		$criteria->compare('pictures',$this->pictures,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('record_id',$this->record_id,true);
		$criteria->compare('source_filename',$this->source_filename,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('import_date',$this->import_date,true);
		$criteria->compare('sync_date',$this->sync_date,true);
		$criteria->compare('import_comment',$this->import_comment,true);
		$criteria->compare('sync_comment',$this->sync_comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return GetyourguideImport the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
