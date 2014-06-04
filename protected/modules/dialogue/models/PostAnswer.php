<?php

/**
 * This is the model class for table "{{post_answer}}".
 *
 * The followings are the available columns in table '{{post_answer}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $question_id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property string $tags
 * @property integer $votes
 * @property string $status
 * @property string $created_date
 * @property string $modified_date
 * @property integer $reply_to
 *
 * The followings are the available model relations:
 * @property PostAnswer $replyTo
 * @property PostAnswer[] $postAnswers
 * @property PostQuestion $question
 * @property User $user
 */

 /**
 * PostAnswer activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $post = PostAnswer::model()
 * ...or
 * ...   $post = new PostAnswer;
 * ...or
 * ...   $post = new PostAnswer($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PostAnswer extends CActiveRecord
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
		return '{{post_answer}}';
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
			array('user_id, question_id, content',                               'required'),
			array('user_id, question_id, votes, reply_to',                       'numerical', 'integerOnly'=>true),
			array('title, alias',                                                'length', 'max'=>255),
		    array('status',                                                      'in','range'=>array('Open','Closed', 'Published', 'Unublished')),
            array('content, tags',                                               'length', 'max'=>4096),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('id, user_id, question_id, title, alias, content, tags, votes, status, created_date, modified_date, reply_to', 'safe', 'on'=>'search'),
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
			'replyTo'            => array(self::BELONGS_TO, 'PostAnswer', 'reply_to'),
			'postAnswers'        => array(self::HAS_MANY, 'PostAnswer', 'reply_to'),
			'question'           => array(self::BELONGS_TO, 'PostQuestion', 'question_id'),
			'user'               => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'id'                 => 'ID',
			'user_id'            => 'User',
			'question_id'        => 'Question',
			'title'              => 'Title',
			'alias'              => 'Alias',
			'content'            => 'Content',
			'tags'               => 'Tags',
			'votes'              => 'Votes',
			'status'             => 'Status',
			'created_date'       => 'Created Date',
			'modified_date'      => 'Modified Date',
			'reply_to'           => 'Reply To',
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
		$criteria->compare('question_id',     $this->question_id);
		$criteria->compare('title',           $this->title,true);
		$criteria->compare('alias',           $this->alias,true);
		$criteria->compare('content',         $this->content,true);
		$criteria->compare('tags',            $this->tags,true);
		$criteria->compare('votes',           $this->votes);
		$criteria->compare('status',          $this->status,true);
		$criteria->compare('created_date',    $this->created_date,true);
		$criteria->compare('modified_date',   $this->modified_date,true);
		$criteria->compare('reply_to',        $this->reply_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PostAnswer the static model class
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
	        $this->created_date = new CDbExpression('NOW()');
	    }

	    // /////////////////////////////////////////////////////////////////
	    // The modified log details is set for record creation and update
	    // /////////////////////////////////////////////////////////////////
	    $this->modified_date = new CDbExpression('NOW()');

	    // /////////////////////////////////////////////////////////////////
	    // Auto set the user id. Set it to the currently logged in user or
	    // '1' otherwise (and) for command line apps too.
	    // /////////////////////////////////////////////////////////////////
	    $this->user_id   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);


	    return parent::beforeSave();
	}
}
