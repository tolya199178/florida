<?php

/**
 * Package Controller interface for the Frontend (Public) packages Module
 */


/**
 * PackageController is a class to provide access to controller actions for
 * ...general processing of user events. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/package/package/action
 * ...eg.
 * ...   http://mydomain/index.php?/package
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. package/package/cart/ will invoke PackageController::actionCart()
 * ...(case is significant)
 *
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class PackageController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * Lists all packages available for purchase
     */
	public function actionIndex() {
        $dbCriteria = new CDbCriteria();
        $dbCriteria->with = array('businessUsers');
        $dbCriteria->condition = "businessUsers.user_id = :user_id";
        $dbCriteria->params = array(':user_id' => Yii::app()->user->id);

        $businessList = Business::model()->findAll($dbCriteria);
        $businessOptions = array();

        foreach($businessList as $business) {
            $businessOptions[$business->business_id] = CHtml::encode($business->business_name);
        }
		$this->render('index', array('businessOptions' => $businessOptions));
	}

    /**
     * loads a page of packages.
     */
    public function actionShowlisting() {
        $page = Yii::app()->request->getQuery('page');

        $dbCriteria = new CDbCriteria();
        $dbCriteria->offset = $page * 15;
        $dbCriteria->limit = 15;

        $packageList = Package::model()->findAll($dbCriteria);

        $this->renderPartial('list', array('packageList' => $packageList));

    }

    /**
     * Shows the shopping cart with the resume of selected packages and a paypal buy button
     */
    public function actionCart() {
        $ids = Yii::app()->request->getParam('package_id');
        array_walk($ids, 'intval');

        $dbCriteria = new CDbCriteria();
        $dbCriteria->addInCondition('package_id', $ids);

        $packageList = Package::model()->findAll($dbCriteria);
        $business = Business::model()->findByPk(Yii::app()->request->getPost('business_id'));

        $data = array(
            'paypalUrl'         => Yii::app()->params['PAYPALURL'],
            'paypalAccount'     => Yii::app()->params['PAYPALACCOUNT'],
            'paypalCurrency'    => Yii::app()->params['PAYPALCURRENCYCODE'],
            'paypalNotifyUrl'   => $this->createUrl('/package/package/paypalipn'),
//            'paypalNotifyUrl'   => $this->createUrl('/package/package/paypalipn'),
            'paypalReturnUrl'   => $this->createUrl('/package'),
            'business'          => $business,
            'packageList'          => $packageList,
            'tax'               => 0
        );

        $this->render('cart', $data);

    }

    /**
     * Saves package purchase data after client clicks the paypal button in the
     * package shopping cart
     */
    public function actionCreatepurchase() {
        $result = array('success' => 0);

        $purchase = new PackagePurchase();
        $purchase['business_id'] = Yii::app()->request->getPost('custom');
        $purchase['status'] = 'created';

        $packageIds = array();
        $totalCost = 0;

        $purchasePackageCount = 1;

        //Builds array of packages purchased using data that will be sent to paypal
        while(Yii::app()->request->getPost('item_number_' . $purchasePackageCount, -1) > 0) {
            $packageIds[] = Yii::app()->request->getPost('item_number_' . $purchasePackageCount);
            $totalCost += Yii::app()->request->getPost('amount_' . $purchasePackageCount, 0);
            $purchasePackageCount++;
        }

        $purchase['total_cost'] = $totalCost;

        // attempts to save the purchase
        if($purchase->save()) {

            // creaes records for packages that are linked to the purchase
            foreach($packageIds as $id) {
                $purchasePackage = new PackagePurchasePackage();
                $purchasePackage['package_purchase_id'] = $purchase->package_purchase_id;
                $purchasePackage['package_id'] = $id;
                $purchasePackage->save();
            }

            $result['success'] = 1;
            $result['packagePurchaseId'] = $purchase->package_purchase_id;

        } else {
            $result['error'] = $purchase->errors;
        }

        echo CJSON::encode($result);

    }



    /**
     * Logs the order placed by the client
     * @return type
     */
    public function  actionPaypalipn()
    {
		$ppLog = new Paypallog();
		$ppLog->action = 'packages';
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

			if($listener->validateIpn($_POST, Yii::app()->params['paypal']['sandbox']))
			{

				if(!isset($_POST['custom'])) {
					$ppLog->result = 'missing custom data user id';
					$ppLog->save();
					return;
				}

				$purchaseId = intval($_POST['custom']);
				$purchase = PackagePurchase::model()->findByPk($purchaseId);

				if(!$purchase) {
				    $ppLog->result = 'wrong purchase id';
				    $ppLog->save();
				    return;
				}

                // Purchase data is correct so it is confirmed
                if ($this->confirmPurchase($purchase)) {
                    $ppLog->result = 'success';
                    $ppLog->save();
                } else {
                    $ppLog->result = 'error confirming purchase';
                    $ppLog->save();
                }
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

    /**
     * TEST FUNCTION
     * IGNORE.
     * RETAIN THIS FUNCTION INTIL THE PAYMENT WORKFLOW IS WORKING.
     */
    public function actionTest() {
//         TODO delete this function
        $purchase = PackagePurchase::model()->findByPk(10);
        $this->confirmPurchase($purchase);
    }

    /**
     * Makes effective a purchase
     * @param type $packagePurchase purchase to make effective
     * @return type
     */
    private function confirmPurchase($packagePurchase) {
        // First check if purchase belings to a valid business
        $business = Business::model()->findByPk($packagePurchase['business_id']);
        if(!$business) {
            echo 'business not found';
            return;
        }

        $date = date('Y-m-d H:i:s');

        // Creates my_package records for every package in the purchase
        foreach($packagePurchase->packages as $package) {
            $this->createMyPackage($package, $business->business_id);
        }

        // marks the purchase as validated
        $packagePurchase['status'] = 'verified';
        $packagePurchase['verified_time'] = $date;
        $packagePurchase->save();
    }


    /**
     * Creates a my_package record
     * @param type $package     package to use as reference
     * @param type $businessId  business_id that owns the my_package record
     */
    private function createMyPackage($package, $businessId) {
        $myPackage = new MyPackage();
        $myPackage->package_id = $package->package_id;
        $myPackage->business_id = $businessId;
        $myPackage->expire_time = date("Y-m-d H:i:s", strtotime("+" . $package->package->package_expire . " days"));
        $myPackage->save();

        // saves my_package_items using package_items as reference
        foreach($package->package->packageItems as $item) {
            $myPackageItem = new MyPackageItem();
            $myPackageItem->my_package_id = $myPackage->my_package_id;
            $myPackageItem->item_type_id = $item->item_type_id;
            $myPackageItem->quantity = $item->quantity;
            $myPackageItem->save();
            // makes item effective
            // item_type_id 3: restaurant_certificates
            switch ($item->item_type_id) {
                case 3: $this->assignCertificates($businessId, $item->quantity); break;
            }
        }
    }

    /**
     * Assigns certificates to a business
     * @param type $businessId      business_id to be assigned
     * @param type $quantity        quantity of certificates to assign
     */
    private function assignCertificates($businessId, $quantity) {
        $date = date('Y-m-d');
        $certificates = RestaurantCertificate::model()->findAll(new CDbCriteria(array('condition' => 'business_id IS NULL', 'limit' => $quantity)));

        foreach($certificates as $certificate) {
            $certificate->business_id = $businessId;
            $certificate->purchased_by_business_date = $date;
            $certificate->save();
            print_r($certificate->errors);
        }
    }
}