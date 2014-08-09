<?php

/**
 * This is the model class for table "{{post_vote}}".
 *
 * The followings are the available columns in table '{{post_vote}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $entity_type
 * @property integer $entity_id
 * @property integer $vote
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property User $user
 */

 /**
 * PostVote activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $vote = PostVote::model()
 * ...or
 * ...   $vote = new PostVote;
 * ...or
 * ...   $vote = new PostVote($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PostVote extends CActiveRecord
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
		return '{{post_vote}}';
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
			array('user_id, entity_type, entity_id, vote',                   'required'),
			array('user_id, entity_id, vote',                                'numerical', 'integerOnly'=>true),
			array('entity_type',                                             'in',
			                                                                 'range'=>array('question', 'answer')),
            // The following rule is used by search(). It only contains attributes that should be searched.
			array('id, user_id, entity_type, entity_id, vote, created_date, modified_date', 'safe', 'on'=>'search'),
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
			'user'      => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'id'             => 'ID',
			'user_id'        => 'User',
			'entity_type'    => 'Entity Type',
			'entity_id'      => 'Entity',
			'vote'           => 'Vote',
			'created_date'   => 'Created Date',
			'modified_date'  => 'Modified Date',
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

		$criteria->compare('id',              $this->id);
		$criteria->compare('user_id',         $this->user_id);
		$criteria->compare('entity_type',     $this->entity_type,true);
		$criteria->compare('entity_id',       $this->entity_id);
		$criteria->compare('vote',            $this->vote);
		$criteria->compare('created_date',    $this->created_date,true);
		$criteria->compare('modified_date',   $this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PostVote the static model class
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
	public function beforeSave()
	{


	    // /////////////////////////////////////////////////////////////////
	    // Set the create time and user for new records
	    // /////////////////////////////////////////////////////////////////
	    if ($this->isNewRecord) {
	        $this->created_time = new CDbExpression('NOW()');
	    }

	    // /////////////////////////////////////////////////////////////////
	    // The modified log details is set for record creation and update
	    // /////////////////////////////////////////////////////////////////
	    $this->modified_time = new CDbExpression('NOW()');

	    // /////////////////////////////////////////////////////////////////
	    // Auto set the user id. Set it to the currently logged in user or
	    // '1' otherwise (and) for command line apps too.
	    // /////////////////////////////////////////////////////////////////
	    $this->user_id   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);


	    return parent::beforeSave();
	}
}