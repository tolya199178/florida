<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $category_id
 * @property integer $parent_id
 * @property string $category_name
 * @property string $category_description
 *
 * The followings are the available model relations:
 * @property Category $parent
 * @property Category[] $categories
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $category = Category::model()
 * ...or
 * ...   $category = new Category;
 * ...or
 * ...   $category = new Category($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Category extends CActiveRecord
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
		return '{{category}}';
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
			array('category_name',           'required'),

		    // Data types, sizes
			array('parent_id',               'numerical', 'integerOnly'=>true),
			array('category_name',           'length', 'max'=>128),
			array('category_description',    'length', 'max'=>255),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('category_id, parent_id, category_name', 'safe', 'on'=>'search'),
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
		    // For child
			'parent'         => array(self::BELONGS_TO, 'Category', 'parent_id'),

		    // For parent
			'categories'     => array(self::HAS_MANY, 'Category', 'parent_id'),
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
			'category_id'            => 'Category',
			'parent_id'              => 'Parent',
			'category_name'          => 'Category Name',
			'category_description'   => 'Category Description',
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

		$criteria->compare('category_id',             $this->category_id);
		$criteria->compare('parent_id',               $this->parent_id);
		$criteria->compare('category_name',           $this->category_name,true);
		$criteria->compare('category_description',    $this->category_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Category the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
