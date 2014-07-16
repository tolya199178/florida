<?php

/**
 * Post Controller interface for the Frontend (Public) Dialogue Module
 */

/**
 * PostController is a class to provide access to controller actions for general
 * ..processing of user friends actions.
 * The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ... http://application.domain/index.php?/dialogue/post/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ... http://mydomain/index.php?/dialogue/show/comment/134/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /dialogue/show/comment/134/ will invoke PostController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /dialogue/show/comment/134/ will pass $_GET['comment'] = '134'
 *
 * @package Controllers
 * @author Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class PostController extends Controller
{

    /**
     * Override layout page.
     *
     * @return string $layout the location of the layout page.
     *
     */
    public $layout = '//layouts/front';

    /**
     * Default controller action.
     * Shows the listing of friends
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {

        // Default action is to show all activitys.
        $this->redirect(array('dashboard'));
    }

    /**
     * Show a list of questions
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {

        // TODO: We should consider pagination
        $listQuestions  = PostQuestion::model()->findAll();

        return $this->render('list', compact('listQuestions'));
    }

    /**
     * Shows details of a specufic question
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionView()
    {
        $questionId         = Yii::app()->request->getParam('question', null);

        $modelQuestion      = PostQuestion::model()->findByPk($questionId);

        if ($modelQuestion)
        {

            if (! (Yii::app()->user->isGuest))
            {
                $modelQuestion->views = $modelQuestion->views + 1;
                $modelQuestion->save();
            }

            $listAnswers    = PostAnswer::model()->findAllByAttributes(array('question_id' => $modelQuestion->id));

            $subview        = 'view';

            return $this->render('question_main', array('data' => compact('modelQuestion', 'listAnswers', 'subview')));
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Post a answer
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionAnswer()
    {
        $formValues     = Yii::app()->request->getPost('PostAnswer');

        $modelAnswer    = new PostAnswer();

        $modelAnswer->attributes = array(
                        'user_id' => Yii::app()->user->id,
                        'question_id' => $formValues['question_id'],
                        'title' => '',
                        'content' => $formValues['content'],
                        'tags' => '',
                        'status' => 'Open',
                        'reply_to' => null
                     );

        if ($modelAnswer->save() === false)
        {

            Yii::app()->user->setFlash('error','Problem saving saved answer. Contact administrator.');


            $this->redirect(Yii::app()->createAbsoluteUrl('/dialogue/post/view', array(
                            'question' => $formValues['question_id']
                   )));
            Yii::app()->end();

        }
        else
        {

            $questionId = $formValues['question_id'];

            $this->notifySubscribers($questionId);

            if ($formValues['notify_updates'] == 1)
            {

                $modelPostSubscription          = PostSubscribed::model()->findByAttributes(
                                                        array('user_id'=>Yii::app()->user->id,
                                                              'post_id'=>$questionId));

                if ($modelPostSubscription === null)
                {
                    $modelPostSubscription          = new PostSubscribed;
                }


                $modelPostSubscription->user_id = Yii::app()->user->id;
                $modelPostSubscription->post_id = $questionId;

                $modelPostSubscription->save();
            }


            Yii::app()->user->setFlash('success','Answer saved.');

            $this->redirect(Yii::app()->createUrl('/dialogue/post/view', array(
                            'question' => $formValues['question_id']
                    )));
        }
    }

    /**
     * Post a question.
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionQuestion()
    {

        $formValues         = Yii::app()->request->getPost('PostQuestion');

        $modelQuestion      = new PostQuestion;

        $modelQuestion->attributes = array(
                        'user_id'       => Yii::app()->user->id,
                        'title'         => $formValues['content'],
                        'alias'         => $formValues['content'],
                        'content'       => $formValues['content'],
                        'tags'          => '',
                        'status'        => 'Open',
                        'category_id'   => $formValues['category_id'],
                        'entity_type'   => 'general',
                        'entity_id'     => '1',
        );


        if ($modelQuestion->save() === false)
        {

            Yii::app()->user->setFlash('error','Problem saving question. Your request could not be processed at this time.');

            $this->redirect(Yii::app()->createUrl('/dialogue/'));
        }
        else
        {

            $questionId = $modelQuestion->id;

            if ($formValues['notify_updates'] == 1)
            {
                $modelPostSubscription          = new PostSubscribed;
                $modelPostSubscription->user_id = Yii::app()->user->id;
                $modelPostSubscription->post_id = $questionId;

                $modelPostSubscription->save();
            }

            Yii::app()->user->setFlash('success','Question saved.');
            $this->redirect(Yii::app()->createUrl('/dialogue/post/view', array(
                'question' => $questionId
            )));
        }
    }

    /**
     * Vote a question or answer up
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionVoteup()
    {
        $argQuestionId  = (int) Yii::app()->request->getQuery('question', 0);
        $argAnswerId    = (int) Yii::app()->request->getQuery('answer', 0);

        if ($argQuestionId != 0)
        {

            $modelQuestion = PostQuestion::model()->findByPk($argQuestionId);

            if ($modelQuestion)
            {

                $modelQuestion->votes ++;

                if ($modelQuestion->save())
                {

                    echo CJSON::encode(array(
                                    'result' => true,
                                    'votes' => $modelQuestion->votes
                                ));
                    Yii::app()->end();
                }
                else
                {

                    echo CJSON::encode(array(
                                    'result' => false,
                                    'votes' => $modelQuestion->votes
                                ));
                    Yii::app()->end();
                }
            }
            else
            {
                echo CJSON::encode(array(
                    'result' => true,
                    'votes' => - 999
                ));
                Yii::app()->end();
            }
        }
        else if ($argAnswerId != 0)
        {
            $modelAnswer = PostAnswer::model()->findByPk($argAnswerId);

            if ($modelAnswer)
            {
                $modelAnswer->votes ++;

                if ($modelAnswer->save())
                {
                    echo CJSON::encode(array(
                                    'result' => true,
                                    'votes' => $modelAnswer->votes
                                ));
                    Yii::app()->end();
                }
                else
                {
                    echo CJSON::encode(array(
                                    'result' => false,
                                    'votes' => $modelAnswer->votes
                                ));
                    Yii::app()->end();
                }
            }
            else
            {
                echo CJSON::encode(array(
                                'result' => false,
                                'votes' => - 999
                            ));
                Yii::app()->end();
            }
        }
    }

    /**
     * Vote a question or answer down
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionVotedown()
    {
        $argQuestionId  = (int) Yii::app()->request->getQuery('question', null);
        $argAnswerId    = (int) Yii::app()->request->getQuery('answer', null);

        if ($argQuestionId != null)
        {

            $modelQuestion = PostQuestion::model()->findByPk($argQuestionId);

            if ($modelQuestion)
            {

                $modelQuestion->votes --;

                if ($modelQuestion->save())
                {

                    echo CJSON::encode(array(
                                    'result' => true,
                                    'votes' => $modelQuestion->votes
                                ));
                    Yii::app()->end();
                }
                else
                {

                    echo CJSON::encode(array(
                                    'result' => false,
                                    'votes' => $modelQuestion->votes
                                ));
                    Yii::app()->end();
                }
            }
            else
            {

                echo CJSON::encode(array(
                                'result' => true,
                                'votes' => - 999
                            ));
                Yii::app()->end();
            }

        }
        else  if ($argAnswerId != null)
        {
            $modelAnswer = PostAnswer::model()->findByPk($argAnswerId);

            if ($modelAnswer)
            {
                $modelAnswer->votes ++;

                if ($modelAnswer->save())
                {
                    echo CJSON::encode(array(
                                    'result' => true,
                                    'votes' => $modelAnswer->votes
                                ));
                    Yii::app()->end();
                }
                else
                {
                    echo CJSON::encode(array(
                                    'result' => false,
                                    'votes' => $modelAnswer->votes
                                ));
                    Yii::app()->end();
                }
            }
            else
            {
                echo CJSON::encode(array(
                                'result' => false,
                                'votes' => - 999
                            ));
                Yii::app()->end();
            }
        }
    }

    /**
     * Search by tag
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionTagsearch()
    {

        // BUG: No mechanism to preveny multiple votes. Cookies were planned, but
        // BUGL ...may become unsutainable due ti volume. Consider a vote logging table.

        $argSearchTerm  = Yii::app()->request->getQuery('tag', null);

        // TODO: We should consider pagination
        $dbCriteria             = new CDbCriteria;

        if ($argSearchTerm != null)
        {
            $dbCriteria->condition  = " FIND_IN_SET(:searchtag, tags) ";
            $dbCriteria->params     = array(':searchtag' => trim($argSearchTerm));
        }

        $listQuestions  = PostQuestion::model()->findAll($dbCriteria);

        return $this->render('list', compact('listQuestions'));
    }

    /**
     * Search by tag
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionEditpost()
    {

        // TODO: Check that only the original poster can edit.

        if (isset($_POST['post_id']))
        {
            $argPostType     = Yii::app()->request->getPost('post_type');
            $argPostId       = Yii::app()->request->getPost('post_id');
            $argQuestion_id  = Yii::app()->request->getPost('static_question_id');

            if ($argPostType == 'question')
            {
                $modelQuestion = PostQuestion::model()->findByPk($argPostId);

                if ($modelQuestion)
                {
                    $modelQuestion->content = Yii::app()->request->getPost('post_content');

                    if ($modelQuestion->save() == false)
                    {

                        print_r($modelQuestion);
                        echo 'The updated post could not be saved. Please try again later.';
                    }

                }

                //  Show the post
                //$listAnswers    = PostAnswer::model()->findAllByAttributes(array('question_id' => $modelQuestion->id));
                //  return $this->render('view', compact('modelQuestion', 'listAnswers'));
                $this->redirect(Yii::app()->createUrl('/dialogue/post/view', array(
                                                'question' => $argQuestion_id
                                            )));

            }
            else
            if ($argPostType == 'answer')
            {
                $modelAnswer = PostAnswer::model()->findByPk($argPostId);

                if ($modelAnswer)
                {
                    $modelAnswer->content = Yii::app()->request->getPost('post_content');

                    if ($modelAnswer->save() == false)
                    {
                        echo 'The updated post could not be saved. Please try again later.';
                    }

                }

//                 //  Show the post
//                 $listAnswers    = PostAnswer::model()->findAllByAttributes(array('question_id' => $argQuestion_id));
//                 return $this->render('view', compact('modelQuestion', 'listAnswers'));
                $this->redirect(Yii::app()->createUrl('/dialogue/post/view', array(
                                                'question' => $argQuestion_id
                                            )));


            }

        }
        else
        {
            $argQuestionId  = (int) Yii::app()->request->getQuery('question', null);
            $argAnswerId    = (int) Yii::app()->request->getQuery('answer', null);

            if ($argQuestionId != null)
            {

                $modelQuestion = PostQuestion::model()->findByPk($argQuestionId);

                if ($modelQuestion)
                {

                    if ($modelQuestion->user_id != Yii::app()->user->id)
                    {
                        echo CJSON::encode(array(
                            'result'    => false,
                            'message'   => 'No permission to edit',
                        ));
                        Yii::app()->end();
                    }

                    echo CJSON::encode(array(
                                    'result'    => true,
                                    'posttype'  => 'question',
                                    'postdata'  => $modelQuestion->attributes
                                ));
                    Yii::app()->end();

                }
                else
                {

                    echo CJSON::encode(array(
                                    'result'    => false,
                                    'message'   => 'Post not found.',
                                ));
                    Yii::app()->end();

                }

            }
            else  if ($argAnswerId != null)
            {
                $modelAnswer = PostAnswer::model()->findByPk($argAnswerId);

                if ($modelAnswer)
                {

                    if ($modelAnswer->user_id != Yii::app()->user->id)
                    {
                        echo CJSON::encode(array(
                            'result'    => false,
                            'message'   => 'No permission to edit',
                        ));
                        Yii::app()->end();
                    }

                    echo CJSON::encode(array(
                                    'result'    => true,
                                    'posttype'  => 'answer',
                                    'postdata'  => $modelAnswer->attributes
                                ));
                    Yii::app()->end();

                }
                else
                {

                    echo CJSON::encode(array(
                                    'result'    => false,
                                    'message'   => 'Post not found.',
                                ));
                    Yii::app()->end();

                }
            }

        }


    }

    /**
     * Displays the discussion dashboard
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionDashboard()
    {

        $configDashboard = array('leftPanel'        => 'left_panel',
                                 'mainPanel'        => 'list'
                           );


        $listRantRaves    = array();
        $listQuestions    = PostQuestion::model()->findAll();
        $listSolutions    = array();


        $dashboardData = array('listQuestions'    => $listQuestions,
                               'listRantRaves'    => $listRantRaves,
                               'listSolutions'    => $listSolutions
                              );

        $this->render('dashboard/dashboard_main', array('config'=>$configDashboard, 'data'=>$dashboardData));

    }

    /**
     * Renders JSON results of friend search in {id,text,image} format.
     * Used for dropdowns
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionAutocompletetaglist()
    {

        $strSearchFilter = $_GET['query'];

        // Don't process short request to prevent load on the system.
        if (strlen($strSearchFilter) < 2)
        {
            header('Content-type: application/json');
            return "";
            Yii::app()->end();

        }

        $lstTags = Yii::app()->db
                             ->createCommand()
                             ->select('category_id AS id, category_name as text')
                             ->from('tbl_category')
                             ->where(array('like', 'category_name', '%'.$strSearchFilter.'%'))
                             ->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($lstTags);

    }

    /**
     * Notify user about changes to question or answer that they subscribed to
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function notifySubscribers($questionId)
    {

        $msgSubject = 'A post you are watching has been updated';
        $msgContent = 'A post you are watching has been updated. Click to see updates.'.
                      Yii::app()->createAbsoluteUrl('//dialogue/post/view/', array('question'=>$questionId));

        $listSubscribers    = PostSubscribed::model()->findAllByAttributes(array('post_id'=>$questionId));

        foreach ($listSubscribers as $recSubscriber)
        {

            $subscriberId = $recSubscriber->user_id;

            MessageService::sendMessage($subscriberId, $msgSubject, $msgContent);

        }


    }

}