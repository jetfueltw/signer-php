<?php

namespace Jetfuel\Signer;

class Signer
{
    /**
     * Create HMAC-SHA256 signature
     *
     * @param string $id
     * @param string $secret
     * @param int $timestamp
     * @param string $baseUrl
     * @param array $parameters
     * @return string
     */
    public static function sign($id, $secret, $timestamp, $baseUrl, $parameters = [])
    {
        $encodedUrl = self::urlEncode(rtrim(strtok($baseUrl, '?'), '/'));
        $encodedParameters = self::generateParameterString($parameters);

        $signData = $id.'&'.$timestamp.'&'.$encodedUrl.'&'.$encodedParameters;

        return self::hmacHash($signData, $secret);
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
    public static function compare($signature, $id, $secret, $timestamp, $baseUrl, $parameters = [])
    {
        return self::sign($id, $secret, $timestamp, $baseUrl, $parameters) === $signature;
    }

    /**
     * Generate a keyed hash value using the HMAC-SHA256 method then to base64 format.
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    private static function hmacHash($data, $key)
    {
        return base64_encode(hash_hmac('sha256', $data, $key, true));
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
    private static function generateParameterString($parameters)
    {
        ksort($parameters);

        return http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
    }
}
