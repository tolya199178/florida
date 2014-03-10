<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $page_id
 * @property string $page_name
 * @property string $page_type
 * @property string $page_contents
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property User $modifiedBy
 * @property User $createdBy
 */

/**
 * User activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $page = Page::model()
 * ...or
 * ...   $page = new Page;
 * ...or
 * ...   $page = new Page($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */
class Page extends CActiveRecord
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
		return '{{page}}';
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
		    array('page_name',            'required'),
		    
		    
		    // Data types, sizes
			array('page_name',           'length', 'max'=>512),
			array('page_type',           'length', 'max'=>6),
		    
			array('page_contents',       'safe'),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('page_id, page_name, page_type, page_contents', 'safe', 'on'=>'search'),
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
			'modifiedBy'     => array(self::BELONGS_TO, 'User', 'modified_by'),
			'createdBy'      => array(self::BELONGS_TO, 'User', 'created_by'),
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
			'page_id'        => 'Page',
			'page_name'      => 'Page Name',
			'page_type'      => 'Page Type',
			'page_contents'  => 'Page Contents',
			'created_time'   => 'Created Time',
			'modified_time'  => 'Modified Time',
			'created_by'     => 'Created By',
			'modified_by'    => 'Modified By',
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

		$criteria->compare('page_id',         $this->page_id);
		$criteria->compare('page_name',       $this->page_name,true);
		$criteria->compare('page_type',       $this->page_type,true);
		$criteria->compare('page_contents',   $this->page_contents,true);
		$criteria->compare('created_time',    $this->created_time,true);
		$criteria->compare('modified_time',   $this->modified_time,true);
		$criteria->compare('created_by',      $this->created_by);
		$criteria->compare('modified_by',     $this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 * @return Page the static model class
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
