<?php

/**
 * Command Class for the shell command LoadGetyourGuideDataCommand to load
 * ...Get your guide data for offline usage.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * LoadGetyourGuideDataCommand is a Yii Console command that copies connects to
 * ...the Ticket Network web servives and imports various data sets for local
 * ...offline access/
 * ...
 *
 * @package Commands
 * @version 1.0
 */


class LoadGetyourGuideDataCommand extends CConsoleCommand
{

    public function run($args)
    {

        date_default_timezone_set('America/New_York');

        // Show the help screen and exit is the user requests
        if (isset($args[0]) && (($args[0] == '-h') || ($args[0] == '--help')))
        {
            $this->showUsage();
            exit();
        }

        // Process the command line options
        $resolvedArgs = $this->resolveRequest($args);
        $userOptions = $resolvedArgs[1];

        // Set default options or override them from the command line
        if (!isset($userOptions['categories']))
        {
            $userOptions['categories'] = 'yes';
        }
        if (!isset($userOptions['locations']))
        {
            $userOptions['locations'] = 'yes';
        }
        if (!isset($userOptions['tours']))
        {
            $userOptions['tours'] = 'yes';
        }
        if (isset($userOptions['overwrite']) && ($userOptions['overwrite'] == 'yes'))
        {
            $optionOverwrite == true;
        }
        else
        {
            $optionOverwrite = false;
        }


        // /////////////////////////////////////////////////////////////////////
        // Get all the Getyourguide categories
        // /////////////////////////////////////////////////////////////////////
        if (isset($userOptions['categories']) && ($userOptions['categories'] == 'yes'))
        {
            $categoryResults    = $this->sendGetRequest('https://api.getyourguide.com/?partner_id=5073458F48&language=en&q=category_list');
            $categoryXmlResults = simplexml_load_string($categoryResults);
            $allCategories      = $this->simpleXMLToArray($categoryXmlResults);
            $listCategories     = $allCategories['categories']['category'];


            // Assign the top level category
            $parentCategoryId   = $this->getCategory("Tour", null);

            foreach ($listCategories as $itemCategory)
            {
                $categoryId     = $this->getCategory($itemCategory['name'], $parentCategoryId);
            }
        }

        // /////////////////////////////////////////////////////////////////////
        // TODO: FOR NOW, WE WILL NOT LOAD THE LOCATION LIST, UNTIL WE FIGURE
        // TODO: ...OUT A WAY TO INTEGRATE GetYourGuide LOCATION DETAILS WITH
        // TODO: ...OUR OWN DATA (Obtained from MaxMind.)
        // /////////////////////////////////////////////////////////////////////

        if (isset($userOptions['location']) && ($userOptions['location'] == 'yes'))
        {
            echo '********************************************************************';
            echo 'Import of GetYourGuide location data is temporarily not implemented.';
            echo '********************************************************************';
        }


        // /////////////////////////////////////////////////////////////////////
        // Get all events from Florida
        // /////////////////////////////////////////////////////////////////////

        if (isset($userOptions['tours']) && ($userOptions['tours'] == 'yes'))
        {
            $productResults     = $this->sendGetRequest('https://api.getyourguide.com/?partner_id=5073458F48&language=en&q=product_list&where=florida&max_results=1000&availability_range=6');
            $productXmlResults  = simplexml_load_string($productResults);
            $allProduct         = $this->simpleXMLToArray($productXmlResults);
            $listProduct        = $allProduct['products']['product'];

            $recordsProcessed       = 0;
            $recordsSuccessfull     = 0;

            foreach ($listProduct as $itemProduct)
            {

                $recordsProcessed++;

                // /////////////////////////////////////////////////////////////
                // Check of the product is not already loaded
                // /////////////////////////////////////////////////////////////
                $recordId = (int) $itemProduct['id'];

                $importRecord = GetyourguideImport::model()->findByAttributes(array('getyourguide_external_id' => $recordId));

                if ($importRecord === null)
                {
                    $importRecord = new GetyourguideImport;
                }

                // //////////////////////////////////////////////////////////////
                // The categories are provided in a list of array elements. We
                // ...extract that imto a single dimensional list and store the
                // ...categories in a serialised form in the import table.
                // //////////////////////////////////////////////////////////////
                $listCategories     = array();

                if (is_array($itemProduct['rating']))
                {
                    $itemProduct['rating'] = 0;
                }

                $importRecord->last_modification_datetime   = trim($itemProduct['last_modification']['datetime']);
                $importRecord->getyourguide_external_id     = (int) $itemProduct['id'];
                $importRecord->title                        = trim($itemProduct['title']);
                $importRecord->abstract                     = trim($itemProduct['abstract']);
                $importRecord->categories                   = serialize($itemProduct['categories']['category']);
                $importRecord->destination                  = serialize($itemProduct['destination']);
                $importRecord->price                        = serialize($itemProduct['price']['values']['value']);;
                $importRecord->prices_description           = serialize($itemProduct['price']['description']);
                $importRecord->rating                       = trim($itemProduct['rating']);
                $importRecord->pictures                     = serialize($itemProduct['pictures']['picture']);
                $importRecord->url                          = trim($itemProduct['url']);
                $importRecord->language                     = trim($itemProduct['language']);

                $importRecord->date_created                 = new CDbExpression('NOW()');

                // /////////////////////////////////////////////////////////////
                // Write, or overwrite the record if soe
                // /////////////////////////////////////////////////////////////
                if ( ($importRecord->isNewRecord == true) ||
                (($importRecord->isNewRecord == false) && ($optionOverwrite === true)) )
                {
                    if ($importRecord->save() === false)
                    {
                        echo "\n".'*** Error saving record #'.($recordsProcessed)."\n";
                        print_r($importRecord->getErrors());
                        print_r($importRecord->attributes);

                        // TODO: Uncomment this if you want the program to stop of save failure
                        // Yii::app()->end();
                    }
                    else
                    {
                        echo 'Record saved **.'."\n";
                        $recordsSuccessfull++;
                    }
                }
                else
                {
                    echo 'Record #'.($recordsProcessed).' not saved (safe mode).'."\n";
                }


            }
        }


        echo "\n\nFinished.\nLoaded $recordsProcessed records.\nSucessful loads : $recordsSuccessfull\n";
        Yii::app()->end();

        // /////////////////////////////////////////////////////////////////////
        // NOTES:
        // The code below is code from the API toolkit for the latest version.
        // ...However, there is a problem is accessing the data using the given
        // ...access token. GetYourGuide has been alerted and we are awaiting
        // ...the feedback and correction.
        // ...Until then, the code above (which works but seems unsupported)
        // ...will be used.
        // /////////////////////////////////////////////////////////////////////


        // $toursPerPage=10;
        // $page=0;//Firstpage
        // $result=$this->callAPI('GET','tours',array(
        // 'q' => 'Florida',
        // 'offset' => $page*$toursPerPage,
        // 'limit' => $toursPerPage,
        // 'date' => '2013-09-02T00:00:00'
        // ));

        // $metadata=$result['_metadata'];
        // $data =$result['data'];

        // echo'Search for "Rome" returned '.$metadata['totalCount'].' results.<br/>';
        // echo'Result page '.($page+1).' of '.ceil($metadata['totalCount']/$toursPerPage);
        // echo'<ul>';
        // foreach($data['tours']as$tour)
        // {
        // echo'<li><a href="'.$tour['url'].'">'.$tour['title'].'</a></li>';
        // }
        // echo'</ul>';

        // exit;

    }

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com GetyourGuide.com Import Utility (cli) (Version : 1.00)
Usage: yiic LoadGetyourGuideDataCommand [options]

where :
--categories=yes|no        - Option to load categories data. Default is {yes}.
--locations=yes|no         - Option to load location data. Default is {yes}.
--tours=yes|no             - Option to load tour data. Default is {yes}.
--overwrite=yes|no         - Option to overwrite tour data. Default is {no}.
\n
EOD;

        echo $usage;
    }

    /**
     * Get the category record. Add the category if it does not exist.
     *
     * @param $bizCategory string The Business category to search (and add if not exist)
     * @param $parentCategoryId int Business parent category id to use
     *
     * @return int categoryId The PK of the located (or newly added) Category;
     * @access private
     */
    private function getCategory($bizCategory, $parentCategoryId = null)
    {

        if (empty($bizCategory))
        {
            return null;
        }

        // Search for the category, and add it if not exist.


        // Fetch the category $bizCategory
        $categoryModel = Category::model()->findByAttributes(array('category_name' => $bizCategory));

        // If the category does not exist, add it
        if ($categoryModel === null)
        {

            echo "Adding new category $bizCategory\n";

            // Add the main category
            $categoryModel                          = new Category;
            $categoryModel->category_name           = trim($bizCategory);
            $categoryModel->category_description    = 'Tours > '.trim($bizCategory);
            $categoryModel->parent_id               = $parentCategoryId;

            $categoryModel->save();
            if ($categoryModel->save() === false)
            {
                echo 'Error saving category record'."\n";
                print_r($categoryModel->getErrors());
                print_r($categoryModel->attributes);
                return null;
            }

        }

        $categoryId                                 = $categoryModel->category_id;
        return $categoryId;


    }


    private function sendGetRequest($remoteUrl)
    {

        // step 1). Initialize CURL session
        $ch = curl_init();

        // step 2). Provide options for the CURL session
        curl_setopt($ch,CURLOPT_URL,$remoteUrl);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //curl_setopt($ch,CURLOPT_HEADER, true); //if you want headers

        // CURLOPT_URL -> URL to fetch
        // CURLOPT_HEADER -> to include the header/not
        // CURLOPT_RETURNTRANSFER -> if it is set to true, data is returned as string instead of outputting it.


        // step 3). Execute the CURL session
        $output=curl_exec($ch);

        // step 4). Close the session
        curl_close($ch);
        return $output;

    }

    private function sendPostRequest($url,$params)
    {
        $postData = '';
        //create name value pairs seperated by &
        foreach($params as $k => $v)
        {
            $postData .= $k . '='.$v.'&';
        }
        rtrim($postData, '&');

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $output=curl_exec($ch);

        curl_close($ch);
        return $output;

    }

    function callAPI($type, $interface, $params = null, $POSTData = null)
    {
        static $APIKey = '5073458F48';
        static $contentLanguage = 'en';

        static $currency = 'eur';

        $cURL = curl_init();


        switch ($type) {
            case 'GET':

                curl_setopt($cURL, CURLOPT_HTTPGET, true);
                break;

            case 'POST':
                curl_setopt($cURL, CURLOPT_POST, 1);
    	        $FinalPOSTData= array(
    	                           'base_data'=> array('cnt_language' => $contentLanguage,
    	                           'currency' => $currency,
    	                           'date'    =>date('Y-m-d\TH:i:s')
    	                        ),
    	            'data' => $POSTData
    	        );

                curl_setopt($cURL, CURLOPT_POSTFIELDS, json_encode($FinalPOSTData));
                break;

            case 'DELETE':
                curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            default:
                // OtherHTTPmethodsarenotsupported
                returnnull;
                break;
        }

        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Accept: application/json;',
            'Accept-Charset: utf-8;'
        ));

        $URL = 'https://api.getyourguide.com/1/' . $interface . '?' . 'cnt_language=' . $contentLanguage . '&currency=' . $currency;

        // curl_setopt($cURL, CURLOPT_HTTPHEADER, "X-ACCESS-TOKEN: $APIKey");
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array("Accept: application/json",
                                                     "X-ACCESS-TOKEN: $APIKey"));

        if (! is_null($params)) {
            $URL .= '&' . http_build_query($params, '', '&');
        }


        echo $URL;
        curl_setopt($cURL, CURLOPT_URL, $URL);

        $responseJSON = curl_exec($cURL);
        $response = json_decode($responseJSON, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $response;
    }


    /**
     * Converts a simpleXML element into an array. Preserves attributes.<br/>
     * You can choose to get your elements either flattened, or stored in a custom
     * index that you define.<br/>
     * For example, for a given element
     * <code>
     * <field name="someName" type="someType"/>
     * </code>
     * <br>
     * if you choose to flatten attributes, you would get:
     * <code>
     * $array['field']['name'] = 'someName';
     * $array['field']['type'] = 'someType';
     * </code>
     * If you choose not to flatten, you get:
     * <code>
     * $array['field']['@attributes']['name'] = 'someName';
     * </code>
     * <br>__________________________________________________________<br>
     * Repeating fields are stored in indexed arrays. so for a markup such as:
     * <code>
     * <parent>
     *     <child>a</child>
     *     <child>b</child>
     *     <child>c</child>
     * ...
     * </code>
     * you array would be:
     * <code>
     * $array['parent']['child'][0] = 'a';
     * $array['parent']['child'][1] = 'b';
     * ...And so on.
     * </code>
     * @param simpleXMLElement    $xml            the XML to convert
     * @param boolean|string    $attributesKey    if you pass TRUE, all values will be
     *                                            stored under an '@attributes' index.
     *                                            Note that you can also pass a string
     *                                            to change the default index.<br/>
     *                                            defaults to null.
     * @param boolean|string    $childrenKey    if you pass TRUE, all values will be
     *                                            stored under an '@children' index.
     *                                            Note that you can also pass a string
     *                                            to change the default index.<br/>
     *                                            defaults to null.
     * @param boolean|string    $valueKey        if you pass TRUE, all values will be
     *                                            stored under an '@values' index. Note
     *                                            that you can also pass a string to
     *                                            change the default index.<br/>
     *                                            defaults to null.
     * @return array the resulting array.
     */
    private function simpleXMLToArray(SimpleXMLElement $xml,$attributesKey=null,$childrenKey=null,$valueKey=null)
    {

        if ($childrenKey && ! is_string($childrenKey))
        {
            $childrenKey = '@children';
        }

        if ($attributesKey && ! is_string($attributesKey))
        {
            $attributesKey = '@attributes';
        }

        if ($valueKey && ! is_string($valueKey))
        {
            $valueKey = '@values';
        }

        $return = array();

        $name = $xml->getName();

        $_value = trim((string) $xml);

        if (! strlen($_value))
        {
            $_value = null;
        }

        if ($_value !== null)
        {
            if ($valueKey)
            {
                $return[$valueKey] = $_value;
            } else
            {
                $return = $_value;
            }
        }

        $children = array();
        $first = true;

        foreach ($xml->children() as $elementName => $child)
        {
            $value = $this->simpleXMLToArray($child, $attributesKey, $childrenKey, $valueKey);

            if (isset($children[$elementName]))
            {
                if (is_array($children[$elementName]))
                {
                    if ($first)
                    {
                        $temp = $children[$elementName];
                        unset($children[$elementName]);
                        $children[$elementName][] = $temp;
                        $first = false;
                    }
                    $children[$elementName][] = $value;
                } else
                {
                    $children[$elementName] = array(
                        $children[$elementName],
                        $value
                    );
                }
            } else
            {
                $children[$elementName] = $value;
            }
        }
        if ($children)
        {
            if ($childrenKey)
            {
                $return[$childrenKey] = $children;
            } else {
                $return = array_merge($return, $children);
            }
        }

        $attributes = array();
        foreach ($xml->attributes() as $name => $value)
        {
            $attributes[$name] = trim($value);
        }
        if ($attributes)
        {
            if ($attributesKey)
            {
                $return[$attributesKey] = $attributes;
            } else
            {
                if (is_string($return))
                {
                    $return = array($return);
                }
                $return = array_merge($return, $attributes);
            }
        }

        return $return;
    }

}

?>