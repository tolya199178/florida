<?php

/**
 * Coupon Controller interface for the Frontend (Public) coupons Module
 */


/**
 * CouponController is a class to provide access to controller actions for
 * ...general processing of user events. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/coupon/coupon/action
 * ...eg.
 * ...   http://mydomain/index.php?/coupon
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. coupon/coupon/cart/ will invoke CouponController::actionCart()
 * ...(case is significant)
 *
 * @coupon   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @coupon Controllers
 * @version 1.0
 */

class CouponController extends Controller
{

    public 	$layout='//layouts/front';

    /**
     * Default controller action.
     * Shows list of all coupons.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
	public function actionIndex()
	{


        CController::forward('/coupon/coupon/list/');


	}



    /**
     * List coupons.
     * Shows list of all coupons.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     * @access public
     */
    public function actionList()
    {

        $myCouponSummary     = $this->getCouponSummary();

        $listCouponsData = Coupon::model()->findAll();

        $arrayDataProvider=new CArrayDataProvider($listCouponsData, array(
            'keyField' => 'coupon_id',
            'id'=>'id',
            /* 'sort'=>array(
             'attributes'=>array(
                 'username', 'email',
             ),
            ), */
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));

        $this->render('coupon_list', array('arrayDataProvider'=>$arrayDataProvider,
                                           'myCouponSummary'  => $myCouponSummary));


    }

    /**
     * Provide a summary of coupon activity for the current business.
     *
     * @param <none> <none>
     *
     * @return <none> <none>
     */
    private function getCouponSummary($businessId = null)
    {

        $summaryResults = array();

        /**
         * If a business id is not supplied, then supply the coupon details for all
         * ...businesses managed by this user.
        */

        if ($businessId === null)
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
        }
        else
        {

            /*
             * Push the filtered business into the business list.
            */

            $businessIds                = array();
            array_push($businessIds, $businessId);
        }


        $dbCriteria                 = new CDbCriteria();
        $dbCriteria->addInCondition('business_id', $businessIds);

        $lstAllMyCertificates       = Coupon::model()->findAll($dbCriteria);

        $summaryResults             = array('countAll'          => 0,
            'countPrinted'      => 0,
            'valuePrinted'      => 0);

        foreach ($lstAllMyCertificates as $itemCertificate)
        {
            $summaryResults['countAll']++;

            if ($itemCertificate->printed == 'Y')
            {
                $summaryResults['countPrinted']++;
                $summaryResults['valuePrinted']++;

            }

        }

        return $summaryResults;

    }

}