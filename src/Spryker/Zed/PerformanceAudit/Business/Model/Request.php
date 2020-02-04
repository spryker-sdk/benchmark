<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Model;

/**
 * Class Request
 *
 * @package Spryker\Zed\PerformanceAudit\Business\Model
 */
class Request
{
    /**
     * @param string $url
     * @param array $headers
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException
     *
     * @return float
     */
    public static function post(string $url, array $headers, array $body, int $expectedStatusCode): float
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        $preparedHeaders = [];
        foreach ($headers as $name => $value) {
            $preparedHeaders[] = "$name: $value";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $preparedHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $info['http_code'], $expectedStatusCode);
            throw new \RuntimeException($msg);
        }

        return $info['starttransfer_time'];
    }

    /**
     * @param string $url
     * @param array $headers
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException
     *
     * @return float
     */
    public static function get(string $url, array $headers, int $expectedStatusCode): float
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        $preparedHeaders = [];
        foreach ($headers as $name => $value) {
            $preparedHeaders[] = "$name: $value";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $preparedHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $info['http_code'], $expectedStatusCode);
            throw new \RuntimeException($msg);
        }

        return $info['starttransfer_time'];
    }

    /**
     * @param string $url
     * @param array $headers
     * @param string $body
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public static function login(string $url, array $headers, string $body, int $expectedStatusCode)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        $preparedHeaders = [];
        foreach ($headers as $name => $value) {
            $preparedHeaders[] = "$name: $value";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        if ($info['http_code'] != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $info['http_code'], $expectedStatusCode);
            throw new \RuntimeException($msg);
        }

        $header = substr($response, 0, $info['header_size']);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
        $cookies = [];

        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        return array_values($cookies)[0];
    }
}
