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
        $this->redirect(array('list'));
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

            return $this->render('view', compact('modelQuestion', 'listAnswers'));
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Post and answer
     *
     * @param
     *            <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionAnswer()
    {
        // print_r($_POST);
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
            echo CJSON::encode(array(
                            'result' => false,
                            'message' => 'Problem saving saved answer. Contact administrator.'
                        ));

            $this->redirect(Yii::app()->createUrl('/dialogue/post/view', array(
                            'question' => $formValues['question_id']
                   )));
            Yii::app()->end();

        }
        else
        {
            $this->redirect(Yii::app()->createUrl('/dialogue/post/view', array(
                            'question' => $formValues['question_id']
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
            } else
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
}