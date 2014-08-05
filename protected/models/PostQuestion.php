<?php

/**
 * This is the model class for table "{{post_question}}".
 *
 * The followings are the available columns in table '{{post_question}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property string $tags
 * @property integer $answers
 * @property integer $views
 * @property integer $votes
 * @property string $status
 * @property integer $category_id
 * @property string $created_date
 * @property string $modified_date
 * @property string $entity_type
 * @property integer $entity_id
 * @property integer $reply_to
 * @property string $post_type
 * @property integer $question_rating_value
 *
 * The followings are the available model relations:
 * @property PostQuestion $replyTo
 * @property PostQuestion[] $postQuestions
 * @property User $user
 */

 /**
 * PostQuestion activerecord model class provides a mechanism to keep data and their
 * ...relevant business rules. A model instant represents a single database row.
 * ...
 * ...Usage:
 * ...   $question = PostQuestion::model()
 * ...or
 * ...   $question = new PostQuestion;
 * ...or
 * ...   $question = new PostQuestion($scenario);
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Components
 * @version 1.0
 */

class PostQuestion extends CActiveRecord
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
		return '{{post_question}}';
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
			array('user_id, title, alias, content, entity_id',                           'required'),
			array('user_id, answers, views, votes, category_id, entity_id, reply_to',    'numerical', 'integerOnly'=>true),
		    array('question_rating_value',                                               'numerical', 'integerOnly'=>true),

			array('title, alias',                                                        'length', 'max'=>255),
			array('status',                                                              'in',
			                                                                             'range'=>array('Open','Closed', 'Published', 'Unublished')),
			array('entity_type',                                                         'in',
			                                                                             'range'=>array('city', 'state', 'business', 'user', 'general', 'event')),
		    array('post_type',                                                           'in',
		        'range'=>array('Question', 'Rant', 'Rave', 'Solution', 'Discussion')),

			array('content, tags',                                                       'length', 'max'=>4096),

            // The following rule is used by search(). It only contains attributes that should be searched.
			array('id, user_id, title, alias, content, tags, answers, views, votes, status, category_id, created_date, modified_date, entity_type, entity_id, reply_to', 'safe', 'on'=>'search'),
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
			'replyTo'            => array(self::BELONGS_TO, 'PostQuestion', 'reply_to'),
			'postQuestions'      => array(self::HAS_MANY, 'PostQuestion', 'reply_to'),
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
			'id'             => 'ID',
			'user_id'        => 'User',
			'title'          => 'Title',
			'alias'          => 'Alias',
			'content'        => 'Content',
			'tags'           => 'Tags',
			'answers'        => 'Answers',
			'views'          => 'Views',
			'votes'          => 'Votes',
			'status'         => 'Status',
			'category_id'    => 'Category',
			'created_date'   => 'Created Date',
			'modified_date'  => 'Modified Date',
			'entity_type'    => 'Entity Type',
			'entity_id'      => 'Entity',
			'reply_to'       => 'Reply To',
		    'post_type'      => 'Post Type',
		    'question_rating_value'       => 'Question Rating Value',
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
		$criteria->compare('title',           $this->title,true);
		$criteria->compare('alias',           $this->alias,true);
		$criteria->compare('content',         $this->content,true);
		$criteria->compare('tags',            $this->tags,true);
		$criteria->compare('answers',         $this->answers);
		$criteria->compare('views',           $this->views);
		$criteria->compare('votes',           $this->votes);
		$criteria->compare('status',          $this->status,true);
		$criteria->compare('category_id',     $this->category_id);
		$criteria->compare('created_date',    $this->created_date,true);
		$criteria->compare('modified_date',   $this->modified_date,true);
		$criteria->compare('entity_type',     $this->entity_type,true);
		$criteria->compare('entity_id',       $this->entity_id);
		$criteria->compare('reply_to',        $this->reply_to);
		$criteria->compare('post_type',       $this->post_type);
		$criteria->compare('question_rating_value',$this->question_rating_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return PostQuestion the static model class
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
	    if ($this->isNewRecord) {
	       $this->user_id   = (Yii::app() instanceof CConsoleApplication || (!(Yii::app()->user->id)) ? 1 : Yii::app()->user->id);
	    }


	    return parent::beforeSave();
	}
}
