<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Model;

use GuzzleHttp\Client;
use RuntimeException;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Config\Config;

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
     * @param array $requestBody
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException
     *
     * @return int
     */
    public function sendPost(string $url, array $headers, array $requestBody, int $expectedStatusCode): int
    {
        $response = $this->getClient()->post(Config::get(ApplicationConstants::HOST_YVES) . $url, [
            'headers' => $headers,
            'body' => $requestBody,
        ]);

        if ($response->getStatusCode() != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $response->getStatusCode(), $expectedStatusCode);
            throw new RuntimeException($msg);
        }

        return $response->getStatusCode();
    }

    /**
     * @param string $url
     * @param array $headers
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException
     *
     * @return int
     */
    public function sendGet(string $url, array $headers, int $expectedStatusCode): int
    {
        $response = $this->getClient()->get(Config::get(ApplicationConstants::HOST_YVES) . $url, [
            'headers' => $headers,
        ]);

        if ($response->getStatusCode() != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $response->getStatusCode(), $expectedStatusCode);
            throw new RuntimeException($msg);
        }

        return $response->getStatusCode();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    private function getClient()
    {
        return new Client();
    }
}
