<?php


/**
 * Helper class for ShortMessage Service facility
 */


/**
 * GamificationService is a class containing functions to provide gamification
 * ...functions to users.
 *
 * Usage:
 * ...Typical usage is from othe application componente (eg, model, or controller)
 * ...
 * ...   GamificationService::helperFunction(arguments ...)
 * ...eg.
 * ...   GamificationService::sendMessage('1234567890');
 * ...
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class GamificationService
{

    /**
     * Notifies the service of an event
     *
     * The caller raised the event and passes the userid, plus any additional
     * ...information that nay be required.
     *
     * @param $eventType string The type of event that is raised
     * @param $userId int The current logged in user
     * @param $additionalInfo mixed Supporting data - optional
     *
     * @return boolean result of event save.
     * @access public
     */
    public static function raiseEvent($eventType, $userId, $additionalInfo = null)
    {

//         /*
//          * Find the event points allocation
//          */
//         $modelPointsAllocation = PointsAllocationMap::model()->findByAttributes(array('event'=>$eventType));

        // Create the event log
        $modelGamificationEvent                 = new UserGamificatonEvent;
        $modelGamificationEvent->user_id        = $userId;
        $modelGamificationEvent->event_type     = $eventType;

        $queryResult = $modelGamificationEvent->save();

        return $queryResult;

    }


}