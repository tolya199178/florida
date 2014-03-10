<?php

/**
 * This is the model class for table "{{photo}}".
 *
 * The followings are the available columns in table '{{photo}}':
 * @property integer $photo_id
 * @property string $photo_type
 * @property integer $entity_id
 * @property string $caption
 * @property string $title
 * @property string $path
 * @property string $thumbnail
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $$photo = Photo::model()
 * ...or
 * ...   $photo = new Photo;
 * ...or
 * ...   $photo = new Photo($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Photo extends CActiveRecord
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
		return '{{photo}}';
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

			array('entity_id',       'required'),

		    // Data types, sizes
			array('entity_id',       'numerical', 'integerOnly'=>true),
			array('caption, title',  'length', 'max'=>255),
			array('path, thumbnail', 'length', 'max'=>512),

			array('photo_type',      'in','range'=>array('Y','N'),'allowEmpty'=>false),

		    // ranges

            // The following rule is used by search(). It only contains attributes that should be searched.

			array('photo_id, photo_type, entity_id, caption, title, path', 'safe', 'on'=>'search'),
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
			'photo_id' 			=> 'Photo',
			'photo_type' 		=> 'Photo Type',
			'entity_id' 		=> 'Entity',
			'caption' 			=> 'Caption',
			'title' 			=> 'Title',
			'path' 				=> 'Path',
			'thumbnail' 		=> 'Thumbnail',
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

		$criteria->compare('photo_id',			$this->photo_id);
		$criteria->compare('photo_type',		$this->photo_type,true);
		$criteria->compare('entity_id',			$this->entity_id);
		$criteria->compare('caption',			$this->caption,true);
		$criteria->compare('title',				$this->title,true);
		$criteria->compare('path',				$this->path,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Photo the static model class
     * 
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
