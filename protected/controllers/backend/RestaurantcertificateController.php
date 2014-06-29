<?php

/**
 * Controller interface for Restuarant Certificate management.
 */

/**
 * Restuarantcertificate Controller class to provide access to controller actions for clients.
 * The controller action interfaces 'directly' with the Client. This controller
 * ...must therefore be responsible for input processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/restuarantcertificate/action/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/restuarantcertificate/edit/certificate_id/99/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /restuarantcertificate/edit/certificate_id/99/ will invoke RestuarantcertificateController::actionEdit()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /restuarantcertificate/edit/certificate_id/99/ will pass $_GET['Restuarantcertificatecertificate_id'] = 99
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */
class RestaurantcertificateController extends BackEndController
{

    /**
     * Controller initailisation routines to set up the controller
     *
     * @param <none> <none>
     *
     * @return array action filters
     * @access public
     */
    public function init()
    {
    }



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

            // delegate to RestuarantCertificate model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('edit'),
            ),

            // delegate to RestuarantCertificate model methods to determine ownership
            array(
                'allow',
                'expression' =>'Yii::app()->user->isAdmin()',
                'actions'    =>array('list', 'index'),
            ),

            array('deny'),
        );


    }


    /**
     * Creates a new restaurant_certificate record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the restaurant_certificate details capture form
     * ... - the (subsequent) POST request saves the submitted post data as a restaurant_certificate record.
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the RestaurantCertificate validation (RestaurantCertificate::rules())
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionCreate()
    {

        $restaurantCertificateModel = new RestaurantCertificate();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($restaurantCertificateModel);

        if(isset($_POST['RestaurantCertificate']))
        {

            $restaurantCertificateModel->attributes             = $_POST['RestaurantCertificate'];

            if($restaurantCertificateModel->save())
            {
                $this->redirect(array('index'));
            }
            else {
                echo 'adasdasdas';
                Yii::app()->user->setFlash('error', "Error creating a restaurant certificate record.'");
            }


        }

        // Show the details screen
        $this->render('details',array(
            'model'=>$restaurantCertificateModel,
        ));

    }


    /**
     * Updates an existing restaurant_certificate record.
     * ...The function is normally invoked twice:
     * ... - the (initial) GET request loads and renders the requested restaurant_certificate
     * ...   details capture form
     * ... - the (subsequent) POST request saves the submitted post data for
     * ...   the existing restaurant_certificate record
     * ...If the save (POST request) is successful, the default method (index()) is called.
     * ...If the save (POST request) is not successful, the details form is shown
     * ...again with error messages from the RestaurantCertificate validation (RestaurantCertificate::rules())
     *
     * @param integer $certificate_id the ID of the model to be updated
     *
     * @return <none> <none>
     * @access public
     */
    public function actionEdit($certificate_id)
    {

        $restauranCeritificateModel = RestaurantCertificate::model()->findByPk((int) $certificate_id);
        if($restauranCeritificateModel===null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }


        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($restauranCeritificateModel);


        if(isset($_POST['RestaurantCertificate']))
        {
            // Assign all fields from the form
            $restauranCeritificateModel->attributes             = $_POST['RestaurantCertificate'];

            if($restauranCeritificateModel->save())
            {
                $this->redirect(array('index'));
            }
            else {
                Yii::app()->user->setFlash('error', "Error creating a restaurant_certificate record.'");
            }

        }

        $this->render('details',array(
            'model'=>$restauranCeritificateModel,
        ));
    }

    /**
     * Deletes an existing restaurant_certificate record.
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

        // TODO: add proper error message . iether flash or raiseerror. Might
        // be difficult when sending ajax response.

        // TODO: Only process ajax request
        $restaurantCertificateId = $_POST['restaurant_certificate_id'];
        $restaurantCertificate = RestaurantCertificate::model()->findByPk((int)$restaurantCertificateId);

        if ($restaurantCertificate == null)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Invalid restaurant certificate"}';
            Yii::app()->end();
        }


        $result = $restaurantCertificate->delete();

        if ($result == false)
        {
            header("Content-type: application/json");
            echo '{"result":"fail", "message":"Failed to mark record for deletion"}';
            Yii::app()->end();
        }

        echo '{"result":"success", "message":""}';
        Yii::app()->end();

    }


    /**
     * Default action for the controller. Invoked when an action is not
     * ....explicitly requested by restuarant certificate
     * Does not perform any processing. Redirects to the desired action instead.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionIndex()
    {
        // Default action is to show all restuarant certificates.
        $this->redirect(array('list'));
    }

    /**
     * Import certificates from csv file
     */
    public function actionImport()
    {
        $importModel = new ImportRestaurantCertificateForm();
        $viewData = array('model' => $importModel, 'imported' => false);

        if(isset($_POST['ImportRestaurantCertificateForm'])) {
            if($importModel->validate()) {
                $viewData['imported'] = true;
                $viewData['importCount'] = 0;
                $file = CUploadedFile::getInstance($importModel, 'csvFile');
                if($file) {
                    $viewData['importCount'] = $this->importCSV(file_get_contents($file->tempName));
                }
            }
        }

        $this->render('import', $viewData);
    }

    public function actionPrice()
    {

    }

    public function actionSummary()
    {
        $total = RestaurantCertificate::model()->count();
        $stock = RestaurantCertificate::model()->count('availability_status = "Available"');
        $this->render('summary', array('total' => $total, 'stock' => $stock));
    }

    /**
     * Show all restaurant_certificate. Renders the restaurant_certificate listing view.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {
        $dataProvider=new CActiveDataProvider('RestaurantCertificate');
        $this->render('list',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Generates a JSON encoded list of all restaurant_certificate.
     * The output is customised for the datatables Jquery plugin.
     * http://www.datatables.net
     *
     * The table plugins send a request for a JSON list based on criteria
     * ...determined by default settings or restuarant certificate bahaviour.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionListjson()
    {

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


        // Only do livesearch if the keyword length < 2 characters
        if (isset($_POST['search']['value']) && (strlen($_POST['search']['value']) > 2))
        {
            $searchCriteria->addSearchCondition('certificate_number', $_POST['search']['value'], true);
        }


        $listRestaurantCertificate  = RestaurantCertificate::model()->findAll($searchCriteria);

        $countRows 		            = RestaurantCertificate::model()->count();
        $countTotalRecords 		    = RestaurantCertificate::model()->count();

        /*
         * Output
         */
        $resultsAdvertTable = array(
            "iTotalRecords"         => $countRows,
            "iTotalDisplayRecords"  => $countTotalRecords,
            "aaData"                => array()
        );

        foreach($listRestaurantCertificate as $itemRestaurantCertificate)
        {

            $businessName = '';
            if($itemRestaurantCertificate->attributes['business_id'] > 0) {
                $businessName = $itemRestaurantCertificate->business->business_name . ' (' . $itemRestaurantCertificate->business->business_email .')';
            }

            $userName = '';
            if($itemRestaurantCertificate->attributes['redeemer_user_id'] > 0) {
                $userName = $itemRestaurantCertificate->user->getFullName() . ' (' . $itemRestaurantCertificate->user->email .')';
            } else {
                $userName = $itemRestaurantCertificate['redeemer_email'];
            }

            $rowResult = array(
                $itemRestaurantCertificate->attributes['certificate_id'],
                $itemRestaurantCertificate->attributes['certificate_number'],
                $itemRestaurantCertificate->attributes['purchase_date'],
                $itemRestaurantCertificate->attributes['purchase_amount'],
                $itemRestaurantCertificate->attributes['purchased_by_business_date'],
                $businessName,
                $itemRestaurantCertificate->attributes['redeem_date'],
                $userName,
                $itemRestaurantCertificate->attributes['certificate_value'],
            );

            $resultsAdvertTable['aaData'][] = $rowResult;

        }

        echo CJSON::encode($resultsAdvertTable);
        Yii::app()->end();

    }


    /**
     * Performs the AJAX validation.
     *
     * @param restuarantCertificateModel $restaurantCertificateModel the model to be validated
     *
     * @return string validation results message
     * @access protected
     */
    protected function performAjaxValidation($restaurantCertificateModel)
    {


        if(isset($_POST['ajax']) && $_POST['ajax']==='restaurant-certificate-details-form')
        {
            echo CActiveForm::validate($restaurantCertificateModel);
            Yii::app()->end();
        }
    }

    /**
     * Imports certificates from csv data
     *
     * @param type $data csv data
     * @return int
     */
    public function importCSV($data)
    {
            // TODO: set variables $fields, $fieldDelimiter, $startRow to match csv format
        $importFields = array(
            'certificate_number',
            'purchase_amount',
            'purchase_date'
        );

        $fieldDelimiter     = ',';
        $startRow           = 1;

        $colCount           = sizeof($importFields);

        $rows = preg_split("/\\r\\n|\\r|\\n/", $data);
        $rowCount = sizeof($rows);
        $importCount = 0;

        for ($i = $startRow; $i < $rowCount; $i ++)
        {
            $cols = explode($fieldDelimiter, $rows[$i]);
            $attributes = array();
            for ($j = 0; $j < $colCount; $j ++)
            {
                if (isset($cols[$j]))
                {
                    $attributes[$importFields[$j]] = $cols[$j];
                }
            }
            $old = RestaurantCertificate::model()->findByAttributes(array(
                'certificate_number' => $attributes['certificate_number']
            ));
            if (!$old)
            {
                $new = new RestaurantCertificate();
                $new->attributes = $attributes;
                if ($new->save())
                {
                    $importCount ++;
                }
            }
        }
        return $importCount;
    }

}