<?php

namespace Ariel\Format_Transformer\Utility;

/**
 * This class is responsible for validating if url is a valid http request
 */
class UrlHttpRequestUtility
{
    /**
     * Quick check if url is roughly a valid http request (ex: http://blah/...)
     *
     * @param string $url
     *
     * @return boolean
     */
    public static function isValidHttpRequest(string $url): bool
    {
        if (!preg_match('/^http(s)?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)) {
            return false;
        }
        
        return true;
    }
}
