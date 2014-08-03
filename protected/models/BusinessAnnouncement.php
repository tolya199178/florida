<?php

/**
 * This is the model class for table "{{business_announcement}}".
 *
 * The followings are the available columns in table '{{business_announcement}}':
 * @property integer $announcement_id
 * @property integer $business_id
 * @property string $content
 * @property string $created_time
 * @property string $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property string $published
 *
 * The followings are the available model relations:
 * @property Business $business
 * @property User $createdBy
 * @property User $modifiedBy
 */

 /**
 * BusinessAnnouncement activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $announcement = BusinessAnnouncement::model()
 * ...or
 * ...   $announcement = new BusinessAnnouncement;
 * ...or
 * ...   $announcement = new BusinessAnnouncement($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class BusinessAnnouncement extends CActiveRecord
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
		return '{{business_announcement}}';
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
			array('business_id',                                             'required'),
			array('business_id',                                             'numerical', 'integerOnly'=>true),
			array('content',                                                 'length', 'max'=>4096),

		    array('published, template, private',                             'in', 'range'=>array('Y','N')),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('announcement_id, business_id, content, created_time, modified_time, created_by, modified_by, published', 'safe', 'on'=>'search'),
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
			'business'       => array(self::BELONGS_TO, 'Business', 'business_id'),
			'createdBy'      => array(self::BELONGS_TO, 'User', 'created_by'),
			'modifiedBy'     => array(self::BELONGS_TO, 'User', 'modified_by'),
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
			'announcement_id'    => 'Announcement',
			'business_id'        => 'Business',
			'content'            => 'Content',
			'created_time'       => 'Created Time',
			'modified_time'      => 'Modified Time',
			'created_by'         => 'Created By',
			'modified_by'        => 'Modified By',
			'published'          => 'Published',
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

		$criteria->compare('announcement_id', $this->announcement_id);
		$criteria->compare('business_id',     $this->business_id);
		$criteria->compare('content',         $this->content,true);
		$criteria->compare('created_time',    $this->created_time,true);
		$criteria->compare('modified_time',   $this->modified_time,true);
		$criteria->compare('created_by',      $this->created_by);
		$criteria->compare('modified_by',     $this->modified_by);
		$criteria->compare('published',       $this->published,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return BusinessAnnouncement the static model class
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
