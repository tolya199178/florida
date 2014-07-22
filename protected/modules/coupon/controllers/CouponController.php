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

//         $listCouponsData=array(
//             array('id'=>1, 'username'=>'from', 'email'=>'array'),
//             array('id'=>2, 'username'=>'test 2', 'email'=>'hello@example.com'),
//         );

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

        $this->render('coupon_list', array('arrayDataProvider'=>$arrayDataProvider));


    }

}