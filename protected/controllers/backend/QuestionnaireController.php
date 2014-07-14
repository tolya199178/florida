<?php

/**
 * Controller interface for Questionnaire management.
 */

/**
 * Questionnaire Controller class to provide access to controller actions for clients.
 * The contriller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/questionnaire/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/questionnaire/edit/questionnaire_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /questionnaire/edit/questionnaire_id/99/ will invoke QuestionnaireController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /questionnaire/edit/questionnaire_id/99/ will pass $_GET['questionnaire_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class QuestionnaireController extends BackEndController
{

    /**
     * Specify a list of filters to apply to action requests
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Override CController access rules and provide base rules for derived class.
     * All derived classes will automatically inherit the access rules provided.
     *
     * @param <none> <none>
     *
     * @return array list of accessrules to apply
     * @access public
     */
    /*
     * TODO: Convert this to use RBAC
     */
    public function accessRules()
    {

        // echo Yii::app()->user->isSuperAdmin();exit;

        return array(
            // Admin has full access. Applies to all controller action.
            array(
                'allow',
                'expression' =>'Yii::app()->user->isSuperAdmin()',
                // 'actions'    =>array('create'),

            ),

            // delegate to advertisement model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('edit'),
            ),

            // delegate to advertisement model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );



    }


    /**
     * Creates a new questionnaire record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the questionnaire details capture form
     * ... - the (subsequent) POST request saves the submitted post data as a Questionnaire record.
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the Questionnaire validation (Questionnaire::rules())
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionCreate()
    {

        $questionnaireModel = new Questionnaire();

        // Uncomment the following line if AJAX validation is needed
        // todo: broken for Jquery precedence order loading
        $this->performAjaxValidation($questionnaireModel);

        if(isset($_POST['Questionnaire']))
        {

            $questionnaireModel->attributes=$_POST['Questionnaire'];

            if($questionnaireModel->save())
            {

                $this->redirect(array('index'));

            }


        }

        // Show the details screen
        $this->render('details',array(
            'model'=>$questionnaireModel,
        ));

    }


    /**
     * Updates an existing questionnaire record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the requested questionnaire's
     * ...   details capture form
     * ... - the (subsequent) POST request saves the submitted post data for
     * ...   the existing Questionnaire record
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the questionnaire validation (Questionnaire::rules())
     *
     * @param integer $questionnaire_id the ID of the model to be updated
     *
     * @return <none> <none>
     * @access public
     */
    public function actionEdit($questionnaire_id)
    {

        $questionnaireModel = Questionnaire::model()->findByPk($questionnaire_id);
        if($questionnaireModel===null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }


        // Uncomment the following line if AJAX validation is needed
        // TODO: Currently disabled as it breaks JQuery loading order
         $this->performAjaxValidation($questionnaireModel);

        if(isset($_POST['Questionnaire']))
        {

            $questionnaireModel->attributes=$_POST['Questionnaire'];


            if($questionnaireModel->save())
            {
                $this->redirect(array('index'));
            }

        }

        $this->render('details',array(
            'model'=>$questionnaireModel,
        ));
    }

    /**
     * Deletes an existing questionnaire record.
     * ...As an additional safety measure, only POST requests are processed.
     * ...Currently, instead of physically deleting the entry, the record is
     * ...modified with the status fields set to 'deleted'
     * ...We also expect a JSON request only, and return a JSON string providing
     * ...outcome details.
     *
     * @param <none> <none>
     *
     * @return string $result JSON encoded result and message
     * @access public
     */
    public function actionDelete()
    {

        // todo: add proper error message . iether flash or raiseerror. Might
        // be difficult is sending ajax response.

        // TODO: Only process ajax request
        $questionnaireId = $_POST['questionnaire_id'];
        $questionnaireModel = Questionnaire::model()->findByPk($questionnaireId);

        if ($questionnaireModel == null) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid questionnaire"}';
            Yii::app()->end();
        }


        $result = $questionnaireModel->delete();

        if ($result == false) {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }

        echo '{"result":"success", "message":""}';
        Yii::app()->end();

    }


    /**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by questionnaire
     * Does not perform any processing. Redirects to the desired action instead.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {
        // Default action is to show all questionnaires.
        $this->redirect(array('list'));
    }


    /**
     * Show all questionnaires. Renders the questionnaire listing view.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {
        $dataProvider=new CActiveDataProvider('Questionnaire');
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Generates a JSON encoded list of all questionnaires.
     * The output is customised for the datatables Jquery plugin.
     * http://www.datatables.net
     *
     * The table plugins send a request for a JSON list based on criteria
     * ...determined by default settings or questionnaire bahaviour.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionListjson() {

        // /////////////////////////////////////////////////////////////////////
        // Create a Db Criteria to filter and customise the resulting results
        // /////////////////////////////////////////////////////////////////////
        $searchCriteria = new CDbCriteria;

        // Paging criteria
        // Set defaults
        $limitStart 	           = isset($_POST['start'])?$_POST['start']:0;
        $limitItems 	           = isset($_POST['length'])?$_POST['length']:Yii::app()->params['PAGESIZEREC'];

        $searchCriteria->limit 		 = $limitItems;
        $searchCriteria->offset 	 = $limitStart;

        if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2)) {
            $searchCriteria->addSearchCondition('t.title', $_POST['search']['value'], true, 'OR');
            $searchCriteria->addSearchCondition('t.question',  $_POST['search']['value'], true, 'OR');

        }


        $lstQuestionnaire          = Questionnaire::model()->findAll($searchCriteria);

        $countRows 		           = Questionnaire::model()->count($searchCriteria);;
        $countTotalRecords 		   = Questionnaire::model()->count();


        $output = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($lstQuestionnaire as $rowQuestionnaire){

            $row = array($rowQuestionnaire->attributes['questionnaire_id'],
                $rowQuestionnaire->attributes['question'],
                $rowQuestionnaire->attributes['title'],
                ''
            );
            $output['aaData'][] = $row;

        }

        echo CJSON::encode($output);

    }


    /**
     * Performs the AJAX validation.
     *
     * @param Questionnaire $questionnaireModel the model to be validated
     *
     * @return string validation results message
     * @access protected
     */
    protected function performAjaxValidation($questionnaireModel)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='questionnaire-details-form')
        {
            echo CActiveForm::validate($questionnaireModel);
            Yii::app()->end();
        }
    }
}
