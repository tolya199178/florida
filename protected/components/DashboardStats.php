<?php

/**
 * Application Level components to provide quick calculation of user activities
 * ...for stats and reporting purposes
 *
 * @package   Components
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * DashboardStats provides reports of activities for various activities linked
 * ...to users, businesses, and events. It provides a quick central collection
 * ...of functions to report on the activities for dashboard and reporting
 * ...purposes.
 *
 * @package Components
 * @version 1.0
 */
class DashboardStats extends CApplicationComponent
{


    /**
     * Report on total page views for a given entity.
     *
     * An entity id and entity type must be supplied to make this report
     * ...meaningful.
     *
     * @param $entityId integer Mandatory entity id. Normally business or user
     * @param $entityType string The type of entity we are querying
     *
     * @return integer The total view count for the entity
     * @access public
     */
    public function totalPageViews($entityId = null, $entityType = 'user')
    {
        if ($entityId === null)
        {
            return 0;
        }

        $pageViews = Yii::app()->db->createCommand()
                               ->select('COUNT(tbl_page_view_id) AS total_page_views')
                               ->from('tbl_page_view')
                               ->where('entity_id=:business_id AND entity_type=:entity_type',
                                       array(':business_id' => $entityId,
                                             ':entity_type' => $entityType
                                       ))
                               ->queryRow();

        return (int) $pageViews['total_page_views'];
    }

    /**
     * Report on total banner views for the given business.
     *
     * @param $businessId integer Mandatory business reference
     *
     * @return integer The total view count for the banner
     * @access public
     */
    public function totalBannerViewsByBusiness($businessId = null)
    {
        if ($businessId === null)
        {
            return 0;
        }

        $bannerViews = Yii::app()->db->createCommand()
                                 ->select('SUM(ads_views) AS total_banner_views')
                                 ->from('tbl_advertisement')
                                 ->where('business_id = :business_id',
                                         array(':business_id' => $businessId))
                                 ->andWhere('advert_type = :advert_type',
                                             array(':advert_type' => 'banner'))
                                 ->queryRow();

        return (int) $bannerViews['total_banner_views'];
    }

    /**
     * Report on total reviews recorded for the given business
     *
     * @param $businessId integer Mandatory business reference
     *
     * @return integer The total review count for the business
     * @access public
     */
    public function totalReviewsByBusiness($businessId = null)
    {
        if ($businessId === null)
        {
            return 0;
        }

        $reviewCount = Yii::app()->db->createCommand()
                                 ->select('COUNT(business_review_id) AS total_reviews')
                                 ->from('tbl_business_review')
                                 ->where('business_id = :business_id',
                                         array(':business_id' => $businessId))
                                 ->queryRow();

        return (int) $reviewCount['total_reviews'];
    }

}