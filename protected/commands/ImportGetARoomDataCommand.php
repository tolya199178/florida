    <?php

/**
 * Command Class for the shell command ImportGetARoomDataCommand to load
 * ...Get-a-Room data for offline usage.
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * ImportGetARoomDataCommand is a Yii Console command that connects to
 * ...the Get-A-Room web services and imports various data sets for local
 * ...offline access/
 * ...
 *
 * @package Commands
 * @version 1.0
 */

# TODO: Remove this line for online processing
# TODO:     ||
# TODO:     ||
# TODO:     ||
# TODO:     \/
define('OFFLINE_MODE', true);

class ImportGetARoomDataCommand extends CConsoleCommand
{

    # the server to hit
    const GAR_DOMAIN            ='https://availability.integration1.testaroom.com';

    # your api key
    const GAR_API_KEY           ='ff0d548b-c6f7-54a1-9dda-f67440b1ea1e';

    # the user authorization token for the user you are wanting to access
    const GAR_AUTH_TOKEN        ='102f2cf5-924f-565e-86c6-2cb535bfe492';

    # the Affiliate token
    const GAR_AFFILIATE_TOKEN   ='ba0aa8f0';


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
        $optionImportProperties = false;
        if (isset($userOptions['properties']) && ($userOptions['properties'] == 'yes'))
        {
            $optionImportProperties = true;
        }

        $optionOverwrite = false;
        if (isset($userOptions['overwrite']) && ($userOptions['overwrite'] == 'yes'))
        {
            echo '*** Running in OVERWRITE MODE ***'."\n";
            $optionOverwrite = true;
        }

        // /////////////////////////////////////////////////////////////////////
        // Get all the Getyourguide categories
        // /////////////////////////////////////////////////////////////////////
        if ($optionImportProperties)
        {
            $requestURL             = self::GAR_DOMAIN.'/api/properties.xml?api_key='.self::GAR_API_KEY.'&auth_token='.self::GAR_AUTH_TOKEN;

            if (defined('OFFLINE_MODE'))
            {
                $propertiesResults  = file_get_contents('/home/pradesh/Workspace/Projects/florida.com/phase2/databases/import/get-a-room/api-master/api.properties/examples/example_properties.xml');
            }
            else
            {
                $propertiesResults  = $this->sendGetRequest($requestURL);
            }

            $propertiesXmlResults   = simplexml_load_string($propertiesResults);
            $allProperties          = $this->simpleXMLToArray($propertiesXmlResults);
            $listProperties         = $allProperties['property'];


            $recordsProcessed       = 0;
            $recordsSuccessfull     = 0;


            foreach ($listProperties as $itemProperty)
            {

                $recordsProcessed++;

                // /////////////////////////////////////////////////////////////
                // Check of the product is not already loaded
                // /////////////////////////////////////////////////////////////
                $recordId = $itemProperty['uuid'];


                $importRecord = GetaroomImport::model()->findByAttributes(array('uuid' => $recordId));

                if ($importRecord === null)
                {
                    $importRecord = new GetaroomImport;
                }

                $amenitiesList = array();
                if (isset($itemProperty['amenities']['amenity']))
                {
                    $amenitiesList = $itemProperty['amenities']['amenity'];
                }

                $importRecord->lat                      = trim($itemProperty['lat'][0]);
                $importRecord->lng                      = trim($itemProperty['lng'][0]);
                $importRecord->location_city            = trim($itemProperty['location-city']);
                $importRecord->location_country         = trim($itemProperty['location-country']);
                $importRecord->location_state           = trim($itemProperty['location-state']);
                $importRecord->location_street          = trim($itemProperty['location-street']);
                $importRecord->location_zip             = trim($itemProperty['location-zip']);
                $importRecord->permalink                = trim($itemProperty['permalink']);

                $importRecord->rating                   = trim($itemProperty['rating'][0]);
                $importRecord->review_rating            = trim($itemProperty['review-rating'][0]);


                $importRecord->short_description        = trim($itemProperty['short-description']);
                $importRecord->thumbnail_filename       = trim($itemProperty['thumbnail-filename']);
                $importRecord->time_zone                = trim($itemProperty['time-zone']);
                $importRecord->title                    = trim($itemProperty['title']);
                $importRecord->uuid                     = trim($itemProperty['uuid']);
                $importRecord->sanitized_description    = trim($itemProperty['sanitized-description']);

                $importRecord->market                   = trim($itemProperty['market']['title']);

                $importRecord->amenity                  = serialize($amenitiesList);


                $importRecord->date_created             = new CDbExpression('NOW()');

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

                        // TODO: Uncomment this if you want the program to stop on save() failure
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

    }

    private function showUsage()
    {
        $usage = <<<EOD
Florida.com GetyourGuide.com Import Utility (cli) (Version : 1.00)
Usage: yiic LoadGetyourGuideDataCommand [options]

where :
--properties=yes|no        - Option to load properties data. Default is {yes}.
--overwrite=yes|no         - Option to overwrite tour data. Default is {no}.
\n
EOD;

        echo $usage;
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


    /**
     * From https://gist.github.com/tfnet/2037443
     *
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