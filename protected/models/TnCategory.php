<?php

/**
 * This is the model class for table "{{tn_category}}".
 *
 * The followings are the available columns in table '{{tn_category}}':
 * @property integer $tn_category_id
 * @property string $ChildCategoryDescription
 * @property integer $ChildCategoryID
 * @property string $GrandchildCategoryDescription
 * @property integer $GrandchildCategoryID
 * @property string $ParentCategoryDescription
 * @property integer $ParentCategoryID
 */

 /**
 * TnCategory activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $category = TnCategory::model()
 * ...or
 * ...   $category = new TnCategory;
 * ...or
 * ...   $category = new TnCategory($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class TnCategory extends CActiveRecord
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
		return '{{tn_category}}';
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
			array('ChildCategoryID, GrandchildCategoryID, ParentCategoryID',
			      'numerical', 'integerOnly'=>true),
			array('ChildCategoryDescription, GrandchildCategoryDescription, ParentCategoryDescription',
			      'length', 'max'=>255),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('tn_category_id, ChildCategoryDescription, ChildCategoryID, GrandchildCategoryDescription, GrandchildCategoryID, ParentCategoryDescription, ParentCategoryID', 'safe', 'on'=>'search'),
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
			'tn_category_id'                 => 'Tn Category',
			'ChildCategoryDescription'       => 'Child Category Description',
			'ChildCategoryID'                => 'Child Category',
			'GrandchildCategoryDescription'  => 'Grandchild Category Description',
			'GrandchildCategoryID'           => 'Grandchild Category',
			'ParentCategoryDescription'      => 'Parent Category Description',
			'ParentCategoryID'               => 'Parent Category',
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

		$criteria->compare('tn_category_id',                  $this->tn_category_id);
		$criteria->compare('ChildCategoryDescription',        $this->ChildCategoryDescription,true);
		$criteria->compare('ChildCategoryID',                 $this->ChildCategoryID);
		$criteria->compare('GrandchildCategoryDescription',   $this->GrandchildCategoryDescription,true);
		$criteria->compare('GrandchildCategoryID',            $this->GrandchildCategoryID);
		$criteria->compare('ParentCategoryDescription',       $this->ParentCategoryDescription,true);
		$criteria->compare('ParentCategoryID',                $this->ParentCategoryID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return TnCategory the static model class
     *
     * @access public
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
