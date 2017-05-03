<?php

namespace Ariel\Format_Transformer\Utility;

/**
 * This class is responsible for validating url by http response
 */
class UrlHttpResponseUtility
{
    /**
     * Check if http response is valid
     *
     * @param string $url
     *
     * @return boolean
     */
    public static function isValidHttpResponse(string $url): bool
    {
        /**
         * List of valid http response(s)
         *
         * @var array
         */
        $validHttpResponse = [
            "OK" => '200',
            "Moved Permanently" => '301' // Used for permanent URL redirection
        ];
        
        $headers = @get_headers($url);
        $httpStatusCode = substr($headers[0], 9, 3);

        if ((!$headers) || (!in_array($httpStatusCode, $validHttpResponse))) {
            return false;
        }
        
        return true;
    }
}
