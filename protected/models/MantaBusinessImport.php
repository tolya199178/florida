<?php

/**
 * This is the model class for table "manta_business_import".
 *
 * The followings are the available columns in table 'manta_business_import':
 * @property integer $id
 * @property integer $import_record_id
 * @property string $breadcrumb
 * @property string $category
 * @property string $sub_category
 * @property string $industry
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property string $website
 * @property string $email
 * @property string $contact
 * @property string $brands
 * @property string $latitude
 * @property string $longitude
 * @property string $businesshours
 * @property string $manta_url
 * @property string $keywords
 */

 /**
 * MantaBusinessImport activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $model = MantaBusinessImport::model()
 * ...or
 * ...   $model = new MantaBusinessImport;
 * ...or
 * ...   $model = new MantaBusinessImport($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class MantaBusinessImport extends CActiveRecord
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
		return 'manta_business_import';
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
			array('import_record_id', 'required'),
			array('import_record_id', 'numerical', 'integerOnly'=>true),
			array('breadcrumb, category, sub_category, industry, company_name, address, city, state, zip, phone, website, email, contact, brands, latitude, longitude, businesshours, manta_url, keywords', 'length', 'max'=>512),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('id, import_record_id, breadcrumb, category, sub_category, industry, company_name, address, city, state, zip, phone, website, email, contact, brands, latitude, longitude, businesshours, manta_url, keywords', 'safe', 'on'=>'search'),
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
			'id'      => 'ID',
			'import_record_id'      => 'Import Record',
			'breadcrumb'      => 'Breadcrumb',
			'category'      => 'Category',
			'sub_category'      => 'Sub Category',
			'industry'      => 'Industry',
			'company_name'      => 'Company Name',
			'address'      => 'Address',
			'city'      => 'City',
			'state'      => 'State',
			'zip'      => 'Zip',
			'phone'      => 'Phone',
			'website'      => 'Website',
			'email'      => 'Email',
			'contact'      => 'Contact',
			'brands'      => 'Brands',
			'latitude'      => 'Latitude',
			'longitude'      => 'Longitude',
			'businesshours'      => 'Businesshours',
			'manta_url'      => 'Manta Url',
			'keywords'      => 'Keywords',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('import_record_id',$this->import_record_id);
		$criteria->compare('breadcrumb',$this->breadcrumb,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('sub_category',$this->sub_category,true);
		$criteria->compare('industry',$this->industry,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('brands',$this->brands,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('businesshours',$this->businesshours,true);
		$criteria->compare('manta_url',$this->manta_url,true);
		$criteria->compare('keywords',$this->keywords,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return MantaBusinessImport the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
