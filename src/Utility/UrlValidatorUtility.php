<?php

namespace Ariel\Format_Transformer\Utility;

/**
 * This class is responsible for validating url
 */
class UrlValidatorUtility
{
    /**
     * @param string $url
     *
     * @return boolean
     */
    public static function validateUrl(string $url): bool
    {
        /**
         * Url should not be null or non-string
         */
        if (!$url || !is_string($url)) {
            return false;
        }

        /**
         * Test if url is valid according to RFC 2396
         */
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        /**
         * Quick check if url is roughly a valid http request (ex: http://blah/...)
         */
        if (!UrlHttpRequestUtility::isValidHttpRequest($url)) {
            return false;
        }
        
        /**
         * Check http response
         */
        if (!UrlHttpResponseUtility::isValidHttpResponse($url)) {
            return false;
        }

        return true;
    }
}
