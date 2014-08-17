<?php

/**
 * Helper function collection for command line utilities to connect to external web services
 *
 * @package   Commands
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 */

/**
 * The collection includes :-
 * ...GetRequest  - to use GET type requests to the URL
 * ...PostRequest - to use POST type requests to the URL. Post data is supplied in an associative array
 * ...XMLToArray  - utility function
 *
 * @package Commands
 * @version 1.0
 */

    /**
     * Send a GET request to a specified remote URL
     *
     * @param string $remoteUrl The destination URL
     *
     * @return mixed the server response
     * @access public
     */
    function sendGetRequest($remoteUrl)
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

    /**
     * Send a POST request to a specified remote URL
     *
     * @param string $remoteUrl The destination URL
     * @param array $params Associative array of POST key-values
     *
     * @return mixed the server response
     * @access public
     */
    function sendPostRequest($url,$params)
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
    function simpleXMLToArray(SimpleXMLElement $xml,$attributesKey=null,$childrenKey=null,$valueKey=null)
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
            $value = simpleXMLToArray($child, $attributesKey, $childrenKey, $valueKey);

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
?>