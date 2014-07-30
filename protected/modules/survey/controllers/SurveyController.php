<?php

/**
 * SurveyController interface for the Frontend survey creation
 */


/**
 * SurveyController is a class to provide access to controller actions for
 * ...survey creaction.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/survey/survey/action
 * ...eg.
 * ...   http://mydomain/index.php?/survey
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. survey/survey/cart/ will invoke surveyController::actionCart()
 * ...(case is significant)
 *
 * @survey   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class SurveyController extends Controller
{
    public 	$layout='//layouts/front';

    /**
     * Controller default action.
     * Displays the users list of surveys
     *
     * @param <none> <none>
     *
     * @return array action list
     * @access public
     */
    public function actionIndex()
    {

        // Find business related to the current user
        $dbCriteria             = new CDbCriteria();
        $dbCriteria->with       = array('businessUsers');
        $dbCriteria->condition  = "businessUsers.user_id = :user_id";
        $dbCriteria->params     = array(':user_id' => Yii::app()->user->id);

        $businessList           = Business::model()->findAll($dbCriteria);

        $businessIds = array();

        foreach($businessList as $itemBusiness) {
            $businessIds[] = $itemBusiness->business_id;
        }

        // Find surveys assigned to business related to the current user
        $dbCriteria             = new CDbCriteria();
        $dbCriteria->addInCondition('business_id', $businessIds);


        $surveyList             = Survey::model()->findAll($dbCriteria);
        $templateList           = Survey::model()->findAllByAttributes(array('template' => 1));

		$this->render('index', array('surveyList' => $surveyList, 'templateList' => $templateList));
	}


	/**
	 * Shows and saves the query creation
	 *
     * @param integer $id if > 0 edits an existing survey
     * @param boolean $template_id if id == 0 and template_id > 0 loads an existing survey as template	 *
     *
	 * @return none none
	 * @access public
	 */
    public function actionEdit($id = 0, $template_id = 0)
    {

        $savedResult                    = false;
        $surveyId                       = $id;
        $surveyModel                    = null;
        $isTemplate                     = false;

        // If there is post data saves the survey
        if (isset($_POST['survey_id']))
        {

            // If editing a templates loads the model esle creates a new survey
            if ($surveyId > 0)
            {
                $surveyModel = Survey::model()->findByPk((int) $surveyId);
            }
            else
            {
                $surveyModel = new Survey;
                $surveyModel->business_id = Yii::app()->request->getPost('business_id');
            }

            // Sets name, if name is emty defaults to New Survey
            $surveyModel->survey_name = Yii::app()->request->getPost('survey_name');

            if (empty($surveyModel->survey_name))
            {
                $surveyModel->survey_name = 'New Survey';
            }

            // Saves the survey
            if ($surveyModel->save() === true)
            {
                $savedResult = true;

            }

            $surveyId = $surveyModel->survey_id;

            // Gets questions posted
            $argQuestions                               = Yii::app()->request->getPost('questions', array());
            $questionIds                                = array();
            $sort                                       = 0;

            // Saves the questions
            foreach($argQuestions as $itemQuestion)
            {
                // If question_id > 0 loads a model to update else creates a new one
                $questionModel = $itemQuestion['question_id'] > 0 ? SurveyQuestion::model()->findByPk($itemQuestion['question_id']) : new SurveyQuestion;

                // sets question data
                $questionModel->survey_id                = $surveyId;
                $questionModel->survey_question_type_id  = $itemQuestion['question_type'];
                $questionModel->question                 = $itemQuestion['question'];
                $questionModel->sort                     = $sort;

                // Save question
                if ($questionModel->save())
                {
                    // inits options data
                    $questionIds[]                      = $questionModel->survey_question_id;
                    $optionIds                          = array();

                    // If question type is select saves options
                    // TODO : Use define value (in model) instead of '2'
                    if ($questionModel->survey_question_type_id == 2)
                    {
                        // Checks if there are options for this question
                        $argOptions                     = isset($itemQuestion['options']) ? $itemQuestion['options'] : array();
                        $optionSort                     = 0;

                        // save options
                        foreach($argOptions as $optionItem)
                        {

                            // if option_id  > 0 loads a model to update else creates a new one
                            $optionModel = $optionItem['option_id'] > 0 ? SurveyQuestionOption::model()->findByPk($optionItem['option_id']) : new SurveyQuestionOption;

                            // set option data
                            $optionModel->value         = $optionItem['option'];
                            $optionModel->question_id   = $questionModel->survey_question_id;
                            $optionModel->sort          = $optionSort;
                            // save option
                            if($optionModel->save())
                            {
                                $optionIds[]            = $option->survey_question_option_id;
                                $optionSort++;
                            }
                        }


                    }

                    // Delete removed option
                    $dbCriteria                         = new CDbCriteria();
                    $dbCriteria->addNotInCondition('survey_question_option_id', $optionIds);
                    $dbCriteria->addCondition('question_id = ' . $questionModel->survey_question_id);
                    SurveyQuestionOption::model()->deleteAll($dbCriteria);

                    $sort++;
                }
            }

            // Find questios removed from the survey
            $dbCriteria                 = new CDbCriteria();
            $dbCriteria->addNotInCondition('survey_question_id', $questionIds);
            $dbCriteria->addCondition('survey_id = ' . $surveyModel->survey_id);

            $questionsToDelete = SurveyQuestion::model()->findAll($dbCriteria);

            // Delete questions removed from the survey with them options
            foreach($questionsToDelete as $questionItem) {

                SurveyQuestionOption::model()->deleteAllByAttributes(array('question_id' => $questionItem->survey_question_id));
                $questionItem->delete();

            }

            $savedResult = true;

            // If template is new redirect to survey edit page after saving
            if($surveyId != $surveyModel->survey_id)
            {
                $this->redirect(array('survey/edit/id/' . $surveyModel->survey_id));
            }
        }

        // If form wasn't saved try to load a model from GET data
        if (!$savedResult)
        {
            // If survey_id > 0 loads a survey to edit else if template_id loads a survey to use as template
            if ($id > 0)
            {
                $surveyModel = Survey::model()->findByPk($surveyId);
            }
            else if($template_id > 0)
            {
                $surveyModel = Survey::model()->findByPk($template_id);
                $isTemplate = true;
            }
        }

        // If creating a new survey gets business list to create business select box
        if ($id > 0)
        {
            $businessList           = array();
        }
        else
        {
            $dbCriteria             = new CDbCriteria();
            $dbCriteria->with       = array('businessUsers');
            $dbCriteria->condition  = "businessUsers.user_id = :user_id";
            $dbCriteria->params     = array(':user_id' => Yii::app()->user->id);
            $businessList           = Business::model()->findAll($dbCriteria);
        }

        // gets question types
        $questionTypes = SurveyQuestionType::model()->findAll();

        $this->render('edit', array(
                                'businessList'      => $businessList,
                                'questionTypes'     => $questionTypes,
                                'survey'            => $surveyModel,
                                'isTemplate'        => $isTemplate,
                              ));

    }


    /**
     * Delete survey
     */
    public function actionDelete()
    {
        // if a suvey id is given
        if(isset($_POST['survey_id']))
        {
            $surveyId = Yii::app()->request->getPost('survey_id', 0);

            /* Load the survey */
            $surveyModel = Survey::model()->findByPk((int) $surveyId);

            // Check if the survey exists
            if ($surveyModel === null)
            {
                echo CJSON::encode(array('result'=>false, 'message'=>'The survey could not be deleted at this time.'));
                Yii::app()->end();
            }

            // Check if the survey owner is the current user
            if ($surveyModel->created_by != Yii::app()->user->id)
            {
                echo CJSON::encode(array('result'=>false, 'message'=>'You re not authorized to perform this request.'));
                Yii::app()->end();
            }

            //TODO Delete answers and responses

            // get questions of the survey

            $listQuestion = SurveyQuestion::model()->findAllByAttributes(array('survey_id' => $surveyId));
            // delete all questions and them options
            foreach($listQuestion as $itemquestion)
            {
                SurveyQuestionOption::model()->deleteAllByAttributes(array('question_id' => $itemquestion->survey_question_id));
                $itemquestion->delete();
            }
            //delete the survey
            if (Survey::model()->deleteByPk($surveyId) <= 0)
            {
                echo CJSON::encode(array('result'=>false, 'message'=>'The survey could not be deleted at this time.'));
                Yii::app()->end();
            }
            else
            {
                echo CJSON::encode(array('result'=>true, 'message'=>'The selected survey has been deleted.'));
                Yii::app()->end();
            }

        }
        else
        {
            echo CJSON::encode(array('result'=>false, 'message'=>'You are not allowed to perform this request.'));
        }

    }

}