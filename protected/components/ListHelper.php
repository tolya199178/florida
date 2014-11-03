<?php


/**
 * Helper class for Lists
 */


/**
 * ListHelper is a class containing functions to provide help with using arrays
 * ...as a data source.
 *
 * Usage:
 * ...Typical usage is from othe application componente (eg, model, or controller)
 * ...
 * ...   ListHelper::helperFunction(arguments ...)
 * ...eg.
 * ...   ListHelper::sendMessage('1234567890');
 * ...
 * @package   Controllers
 * @author    Pradesh <pradesh@datacraft.co.za>
 * @copyright 2014 florida.com
 * @package Controllers
 * @version 1.0
 */

class ListHelper
{

    /**
     * Search a list for matches in the key
     *
     * @param $arrayDataSet array The list haystack
     * @param $searchTerm string The search term
     * @param $returnType string 'key-value' or null
     *
     * @return array Matched entries
     * @access public
     */


    public static function findByKey($arrayDataSet, $searchTerm, $returnType = '')
    {

        $searchTerm     = str_replace( '\*', '.*?', preg_quote( $searchTerm, '/' ) );
        $searchResult   = preg_grep( '/^' . $searchTerm . '$/i', array_keys( $arrayDataSet ) );

        if ( $returnType == 'key-value' ) {
            return array_intersect_key( $arrayDataSet, array_flip( $searchResult ) );
        }

        return $searchResult;
    }

    /**
     * Search a list for matches in the values
     *
     * @param $arrayDataSet array The list haystack
     * @param $searchTerm string The search term
     * @param $returnType string 'key-value' or null
     *
     * @return array Matched entries
     * @access public
     */


    public static function findByValue($arrayDataSet, $searchTerm, $returnType = '')
    {

        $searchTerm     = str_replace( '\*', '.*?', preg_quote( $searchTerm, '/' ) );
        $searchResult   = preg_grep( '/^' . $searchTerm . '$/i', array_values( $arrayDataSet ) );

        if ( $returnType == 'key-value' ) {
            return array_intersect( $arrayDataSet, $searchResult );
        }

        return $searchResult;
    }


    /**
     * Search a list for matches in the values
     *
     * @param $arrayDataSet array The list haystack
     * @param $searchTerm string The search term
     * @param $returnType string 'key-value' or null
     *
     * @return array Matched entries
     * @access public
     */


    public static function convertListToAssociativeList($arrayDataSet, $index)
    {

        $associativeArray = array_combine(array_map(function (array $row) { return $row[$index]; }, $arrayDataSet),
                               $arrayDataSet);

        return $associativeArray;
    }


//      public static function searchArrayValueByKey(array $array, $search) {
//         foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array)) as $key => $value) {
//             echo $key;
//             if ($search === $key)
//                 return $value;
//         }
//         return false;
//     }


/**
 * Search a recursive array a matching key-value combination with a wildcard search
 *
 * @param $needleKey string The array key to search for
 * @param $needleValue string The value to match
 * @param $hayStack array  Recursive array of key-value arrays
 *
 * @return array Matched entries
 * @access public static
 */
    public static function findValue($needleKey, $needleValue, $hayStack) {

        $matchedRecords = array();

        foreach ($hayStack as $searchKey => $searchValue) {

            if (strpos($searchValue[$needleKey], $needleValue) !== false) {
                $matchedRecords[] = $searchKey;
            }

        }
        return ((count($matchedRecords))?$matchedRecords:false);
    }

}
