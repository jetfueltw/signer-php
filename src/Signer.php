<?php

namespace Jetfuel\Signer;

class Signer
{
    /**
     * Generate signature.
     *
     * @param string $appId
     * @param string $appSecret
     * @param int $timestamp
     * @param string $method
     * @param string $baseUrl
     * @param array $parameters
     * @param string $content
     * @return string
     */
    public static function sign($appId, $appSecret, $timestamp, $method, $baseUrl, array $parameters = [], $content = '')
    {
        $method = strtoupper($method);
        $baseUrl = self::urlEncode(self::removeQueryString($baseUrl));
        $parameterString = self::buildParameterString($parameters);

        $baseString = $appId.'&'.$timestamp.'&'.$method.'&'.$baseUrl.'&'.$parameterString.'&'.$content;

        return self::hmacHash($baseString, $appSecret);
    }

    /**
     * Compare signatures is match, with timing attack safe string comparison
     *
     * @param string $signature
     * @param string $appId
     * @param string $appSecret
     * @param int $timestamp
     * @param string $method
     * @param string $baseUrl
     * @param array $parameters
     * @param string $content
     * @return bool
     */
    public static function compare($signature, $appId, $appSecret, $timestamp, $method, $baseUrl, array $parameters = [], $content = '')
    {
        return hash_equals(self::sign($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters, $content), $signature);
    }

    /**
     * Remove query string and slash end.
     *
     * @param string $url
     * @return string
     */
    private static function removeQueryString($url)
    {
        return rtrim(strtok($url, '?'), '/');
    }

    /**
     * URL encode according to RFC 3986 specifications.
     *
     * @param string $url
     * @return string
     */
    private static function urlEncode($url)
    {
        return rawurlencode($url);
    }

    /**
     * Sort parameters by key and generate URL-encoded query string according to RFC 3986.
     *
     * @param array $parameters
     * @return string
     */
    private static function buildParameterString(array $parameters)
    {
        ksort($parameters);

        return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Generate a keyed hash value using the SHA256 algorithm default and base64 format.
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    private static function hmacHash($data, $key)
    {
        return base64_encode(hash_hmac('sha256', $data, $key, true));
    }
}
