<?php

namespace Jetfuel\Signer;

class Signer
{
    /**
     * Generate HMAC-SHA256 signature only include timestamp.
     * This signature CANNOT make sure your data is correct.
     * https://en.wikipedia.org/wiki/Man-in-the-middle_attack
     *
     * @param string $appId
     * @param string $appSecret
     * @param int $timestamp
     * @return string
     */
    public static function signExceptContent($appId, $appSecret, $timestamp)
    {
        $baseString = $appId.'&'.$timestamp;

        return self::hmacHash($baseString, $appSecret);
    }

    /**
     * Generate HMAC-SHA256 signature.
     * Content-Type: application/x-www-form-urlencoded
     *
     * @param string $appId
     * @param string $appSecret
     * @param int $timestamp
     * @param string $method
     * @param string $baseUrl
     * @param array $parameters
     * @return string
     */
    public static function signFormContent($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters = [])
    {
        $method = strtoupper($method);
        $baseUrl = self::urlEncode(rtrim(strtok($baseUrl, '?'), '/'));
        $parameterString = self::buildParameterString($parameters);

        $baseString = $appId.'&'.$timestamp.'&'.$method.'&'.$baseUrl.'&'.$parameterString;

        return self::hmacHash($baseString, $appSecret);
    }

    /**
     * @param string $appId
     * @param string $appSecret
     * @param int $timestamp
     * @param string $method
     * @param string $baseUrl
     * @param array $querys
     * @param string $body
     * @return string
     */
    public static function signJsonContent($appId, $appSecret, $timestamp, $method, $baseUrl, $querys = [], $body = '')
    {
        $method = strtoupper($method);
        $baseUrl = self::urlEncode(rtrim(strtok($baseUrl, '?'), '/'));
        $queryString = self::buildParameterString($querys);
        $body = preg_replace('/\s+/', '', $body);

        $baseString = $appId.'&'.$timestamp.'&'.$method.'&'.$baseUrl.'&'.$queryString.'&'.$body;

        var_dump($baseString);

        return self::hmacHash($baseString, $appSecret);
    }

    /**
     * Compare the two signatures is match.
     *
     * @param string $signature
     * @param string $id
     * @param string $secret
     * @param int $timestamp
     * @param string $baseUrl
     * @param array $parameters
     * @return bool
     */
    // public function compare($signature, $id, $secret, $timestamp, $baseUrl, $parameters = [])
    // {
    //     // return hash_equals(base64_encode(hash_hmac('sha256', $body, $channelSecret, true)), $signature);
    //     // return $this->sign($id, $secret, $timestamp, $baseUrl, $parameters) === $signature;
    // }

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
    private static function buildParameterString($parameters)
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
