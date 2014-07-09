<?php

/**
 * Restaurant.com Certificate Controller interface for the Frontend (Public) Certificates Module
 */


/**
 * CertificatesController is a class to provide access to controller actions for the
 * ...resturant certificates (front-end). The controller action interfaces directly' with
 * ...the Client, and must therefore be responsible for input processing and
 * ...response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/certificates/profile/show/attribute1/parameter1/.../attribute-n/parameter-n/
 * ...eg.
 * ...   http://mydomain/index.php?/certificates/profile/show/name/toms/
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. /certificates/profile/show/name/toms-diner/ will invoke ProfileController::actionShow()
 * ...(case is significant)
 * ...Additional parameters after the action are passed as $_GET pairs
 * ...eg. /certificates/profile/show/name/toms/ will pass $_GET['name'] = 'toms'
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */


class CertificatesController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * Default action of the controller. Displays the certifacete page.
     *
     * @param <none> <none>
     *
     * @return array relational rules.
     * @access public
     */
	public function actionIndex()
	{
        // get business list to be used in the business filter select
        $dbCriteria                         = new CDbCriteria();
        $dbCriteria->with                   = array('businessUsers');
        $dbCriteria->condition              = "businessUsers.user_id = :user_id";
        $dbCriteria->params                 = array(':user_id' => Yii::app()->user->id);

        $businessList = Business::model()->findAll($dbCriteria);

		$this->render('index', array('businessList' => $businessList));
	}


	/**
	 * Builds list of user certificates
	 *
	 * @param <none> <none>
	 *
	 * @return array relational rules.
	 * @access public
	 */
    public function actionCertificatelisttable()
    {
        $dbCriteria = new CDbCriteria();

        if (isset($_GET['business']) && $_GET['business'] > 0)
        {
            // only lists certificates of one business
            $dbCriteria->addCondition("business_id = " . intval($_GET['business']));
        }
        else
        {
            // lists certificates of all business of the current user
            $inDdbCriteria              = new CDbCriteria();
            $inDdbCriteria->with        = array('businessUsers');
            $inDdbCriteria->condition   = "businessUsers.user_id = :user_id";
            $inDdbCriteria->params      = array(':user_id' => Yii::app()->user->id);

            $businessList               = Business::model()->findAll($inDdbCriteria);
            $businessIds                = array();

            foreach ($businessList as $businessItem)
            {
                array_push($businessIds, $businessItem['business_id']);
            }

            $dbCriteria->addInCondition('business_id', $businessIds);
        }

        if (isset($_GET['allocated']))
        {
            if ($_GET['allocated'] == 0)
            {
                // only lists certificates that have't been allocated
                $dbCriteria->addCondition("redeem_date IS null");
            }
            else if ($_GET['allocated'] == 1)
            {
                // only lists certificates that have been allocated
                $dbCriteria->addCondition("redeem_date IS NOT null");
            }
        }

        $itemsPerPage           = 20;

        $pageCount              = ceil(RestaurantCertificate::model()->count($dbCriteria) / $itemsPerPage);
        $page                   = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $dbCriteria->offset     = ($page - 1) * $itemsPerPage;
        $dbCriteria->limit      = $itemsPerPage;

        $data                   = RestaurantCertificate::model()->findAll($dbCriteria);

        $this->renderPartial('tabs/certificate-list-table', array(
            'data' => $data,
            'pageCount' => $pageCount,
            'page' => $page
        ));
    }


    /**
     * Allocates a certificate to a user or email
     *
     * @param <none> <none>
     *
     * @return array relational rules.
     * @access public
     */
    public function actionAllocate()
    {
        $actionResult = array(
            'success' => 0
        );

        if (isset($_POST['certificate_id']))
        {
            $itemCertificate = RestaurantCertificate::model()->findByPk(intval($_POST['certificate_id']));

            if (! $itemCertificate)
            {
                $actionResult['message'] = 'certificate not found';
            }
            else {

                $itemCertificate['redeem_date'] = date('Y-m-d');

                if ($_POST['allocate_target'] == 'user')
                {
                    // allocate to an eixistig user
                    $redeemerUser = User::model()->findByPk(intval($_POST['allocate_user']));

                    if (! $redeemerUser)
                    {
                        $actionResult['message'] = 'user not found';
                    }
                    else
                    {
                        $itemCertificate['redeemer_user_id'] = $redeemerUser->user_id;

                        if ($itemCertificate->save())
                        {
                            $actionResult['success'] = 1;
                        }
                        else
                        {
                            $actionResult['message'] = 'Unable to save certificate record.';
                        }
                    }
                }
                else
                {

                    // allocate to an email
                    $validator = new CEmailValidator();

                    if ($validator->validateValue($_POST['allocate_email']))
                    {

                        $itemCertificate['redeemer_email'] = $_POST['allocate_email'];

                        if ($itemCertificate->save())
                        {
                            $actionResult['success'] = 1;
                        }
                        else
                        {
                            $actionResult['message'] = 'Unable to save certificate record.';
                        }
                    }
                    else
                    {
                        $actionResult['message'] = 'The email you entered is not valid.';
                    }
                }
            }
        }
        echo CJSON::encode($actionResult);
    }

    /**
     * Issues a certificate
     *
     * @param <none> <none>
     *
     * @return array relational rules.
     * @access public
     */
    public function actionIssue()
    {

        $argCertificateId = Yii::app()->request->getQuery('id', 'null');

        if ($argCertificateId === null)
        {
            Yii::app()->user->setFlash('error','Your request could not be processed at this time.');
            $this->redirect(array('/certificates/certificates/'));
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////////
        // Get the certificate
        // /////////////////////////////////////////////////////////////////////
        $certificateModel = RestaurantCertificate::model()->findByPk((int) $argCertificateId);
        if ($certificateModel === null)
        {
            Yii::app()->user->setFlash('error','The requested certificate was not found.'.$argCertificateId);
            $this->redirect(array('/certificates/certificates/'));
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////////
        // We cannot perform this if the certificate has been redeemed.
        // /////////////////////////////////////////////////////////////////////
        if ((!empty($certificateModel->redeemer_user_id)) || (!empty($certificateModel->redeem_date)))
        {
            Yii::app()->user->setFlash('error','The requested is already redeemed and cannot be used again.');
            $this->redirect(array('/certificates/certificates/'));
            Yii::app()->end();
        }

        // /////////////////////////////////////////////////////////////////////
        // Passed all validations. We can issue the code.
        // /////////////////////////////////////////////////////////////////////
        $certificateModel->issue_date   = date('Y-m-d');
        $certificateModel->redeem_code  = uniqid('FLO');

        if ($certificateModel->save() === false)
        {
            Yii::app()->user->setFlash('error','Failed to update the certificate.');
            $this->redirect(array('/certificates/certificates/'));
            Yii::app()->end();
        }

        $this->render("printed_certificate", array('unique_code'=> strtoupper($certificateModel->redeem_code)));
        Yii::app()->end();

    }


    /**
     * Shows cart resume and paypal buy button
     *
     * @param <none> <none>
     *
     * @return array relational rules.
     * @access public
     */
    public function actionCartconfirm()
    {

        $strError         = '';

        $purchaseQuantity = (int) Yii::app()->request->getPost('quantity', 0);
        if ($purchaseQuantity < 1)
        {
            $strError = 'invalid certificate quantity';
        }


        if (!$strError)
        {
            $businessId       = Yii::app()->request->getPost('quantity', null);
            if (empty($businessId))
            {
                $strError   = 'Business is not specified.';
            }
        }



        if (!$strError)
        {
            $businessModel    = Business::model()->findByPk(intval($_POST['business_id']));
            if ($businessModel === null)
            {
                $strError   = 'Business is not specified.';
            }
        }


        if (!$strError)
        {
            $certPriceModel    = SystemSetting::model()->find('attribute = "restaurant_certificate_cost"');
        }

        if (!$strError)
        {
            $availableCerts   = RestaurantCertificate::model()->count('business_id IS NULL');
        }

        if ($purchaseQuantity > $availableCerts)
        {
            $strError = 'Sorry, currently we only have ' . $availableCerts . ' available';
        }


        if (strlen($strError) > 0)
        {
            echo CJSON::encode(array(
                'success' => 0,
                'data' => $strError
            ));
            return;
        }

        $data = array(
            'paypalUrl'         => Yii::app()->params['PAYPALURL'],
            'paypalAccount'     => Yii::app()->params['PAYPALACCOUNT'],
            'paypalCurrency'    => Yii::app()->params['PAYPALCURRENCYCODE'],
            'paypalNotifyUrl'   => $this->createUrl('/certificates/certificates/paypalipn'),
            'paypalReturnUrl'   => $this->createUrl('/certificates'),
            'certQuantity'      => $purchaseQuantity,
            'business'          => $businessModel,
            'certPrice'         => $certPriceModel['value'],
            'tax'               => 0
        );

        // $this->renderPartial('tabs/cart-confirm', $data);
        echo CJSON::encode(array(
            'success' => 1,
            'data' => $this->renderPartial('tabs/cart-confirm', $data, true)
        ));
    }


    public function  actionPaypalipn() {
		$ppLog = new Paypallog();
		$ppLog->action = 'certificates';
		$ppLog->result = '';
		$ppLog->raw = 'none';

		if(!Yii::app()->request->isPostRequest) {
			$ppLog->result = 'no post';
			$ppLog->save();
			return;
		}

		$ppLog->raw = http_build_query($_POST, '', ', ');
//
		if(!isset($_POST['txn_type'])) {
			$ppLog->result = 'no post txn_type';
			$ppLog->save();
			return;
		}

		$ppLog->txn_type = $_POST['txn_type'];

		if($_POST['txn_type'] != 'subscr_payment') {
			$ppLog->result = 'wrong txn_type';
			$ppLog->save();
			return;
		}

		if($_POST['payment_status'] !== 'Completed') {
			$ppLog->result = 'payment not completed';
			$ppLog->save();
			return;
		}

		if(!isset($_POST['ipn_track_id'])) {
			$ppLog->resut = 'no ipn_track_ids';
			$ppLog->save();
			return;
		}
//
		$ppLog->ipn_track_id = $_POST['ipn_track_id'];

		$listener = new IpnVerify();

		try {
			if($listener->validateIpn($_POST, Yii::app()->params['paypal']['sandbox'])) {
				if(!isset($_POST['custom'])) {
					$ppLog->result = 'missing custom data user id';
					$ppLog->save();
					return;
				}
				$businessId = intval($_POST['custom']);
				if($businessId < 1) {
					$ppLog->result = 'wrong user id';
					$ppLog->save();
					return;
				}
                $business = Business::model()->findByPk($businessId);
				if(!$business) {
					$ppLog->result = 'user not found';
					$ppLog->save();
					return;
				}
                $quantity = intval($_POST['quantity1']);
                if($quantity < 1) {
                    $ppLog->result = 'invalid quantity';
					$ppLog->save();
					return;
                }

                $certs = RestaurantCertificate::model(new CDbCriteria(array('condition' => 'business_id IS NULL', 'limit' => $quantity)));

                foreach($certs as $cert) {
                    $cert['business_id'] = $business['business_id'];
                    $cert['purchased_by_business_date'] = date('Y-m-d H:i:s');
                    $cert->save();
                }

				$ppLog->result = 'success';
				$ppLog->save();
			}
			else {
				$ppLog->result = 'invlid ipn :: ' . $listener->error;
				$ppLog->save();
			}
		}
		catch(Exception $e) {
			$ppLog->result = $listener ? $listener->uri . ': ' . $e->getMessage() : $e->getMessage();
			$ppLog->save();
		}
    }

}