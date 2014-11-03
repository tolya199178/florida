<?php

/**
 * Location Controller interface for the Frontend (Public) locations Module
 */


/**
 * LocationController is a class to provide access to controller actions for
 * ...general processing of Location requests. The controller action interfaces
 * ...'directly' with the Client, and must therefore be responsible for input
 * ...processing and response handling.
 *
 * Usage:
 * ...Typical usage is from a web browser, by means of a URL
 * ...
 * ...   http://application.domain/index.php?/location/location/action
 * ...eg.
 * ...   http://mydomain/index.php?/location
 * ...
 * ...The 'action' in the request is converted to invoke the actionAction() action
 * ...eg. location/location/cart/ will invoke LocationController::actionCart()
 * ...(case is significant)
 *
 * @location   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @location Controllers
 * @version 1.0
 */

class LocationController extends Controller
{

	/**
	 * Renders JSON results of city search in {id,text} format.
	 * Used for autocomplete dropdowns
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionAutocompletecitylist()
	{

        $strSearchFilter = $_GET['query'];

        // Don't process short request to prevent load on the system.
        if (strlen($strSearchFilter) < 3)
        {
            header('Content-type: application/json');
            return "";
            Yii::app()->end();

        }

        $lstCities = Yii::app()->db
                               ->createCommand()
                               ->select('city_id AS id, city_name AS text')
                               ->from('tbl_city')
                               ->where(array('LIKE', 'city_name', '%'.$_GET['query'].'%'))
                               ->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($lstCities);

	}

	/**
	 * Fires off a search and returns all results to the client.
	 *
	 * @param <none> <none>
	 *
	 * @return <none> <none>
	 * @access public
	 */
	public function actionCitygallery()
	{

	    $argCityName  = Yii::app()->request->getPost('city', null);

	    // /////////////////////////////////////////////////////////////////////
	    //  Find city record from city name
	    // /////////////////////////////////////////////////////////////////////
	    if ($argCityName != null)
	    {
	        $cityModel = City::model()->findByAttributes(array('city_name' => $argCityName));
	        if ($cityModel != null)
	        {
	            $cityId = $cityModel->city_id;

	            // /////////////////////////////////////////////////////////////
	            // Get all photos for the city
	            // /////////////////////////////////////////////////////////////
	            $lstCityPhotos  = Photo::model()->findAllByAttributes(array('entity_id' => $cityId, 'photo_type' => 'city'));

	            // If there are no images, load the no-image by creating a psudeo-model. Remember not to save!
	            if (count($lstCityPhotos) <= 0)
	            {
	                $psuedoPhotoModel = new Photo();
	                $psuedoPhotoModel->attributes =
	                array('photo_type'  => 'city',
	                    'title'       => 'No image found',
	                    'caption'     => 'No image found',
	                    'path'        => Yii::app()->theme->baseUrl.'/'.Yii::app()->params['NOIMAGE_PATH']
	                );

	                $lstCityPhotos[]    = $psuedoPhotoModel;

	            }

	            $this->renderPartial('city_gallery', array('lstCityPhotos'=> $lstCityPhotos));


	            Yii::app()->end();

	        }

	    }

	}
}