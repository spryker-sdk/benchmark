<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Class SharedRequest
 *
 * @package Spryker\Yves\PerformanceAudit\Request
 */
abstract class SharedRequest implements RequestInterface
{
    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @throws \RuntimeException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(string $method, string $url, array $options, int $expectedStatusCode): ResponseInterface
    {
        $response = $this->getClient()->request($method, $this->getRequestBaseUrl() . $url, $options);

        if ($response->getStatusCode() !== $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $response->getStatusCode(), $expectedStatusCode);

            throw new RuntimeException($msg);
        }

        return $response;
    }

    /**
     * @return string
     */
    abstract protected function getRequestBaseUrl(): string;

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    abstract protected function getClient(): ClientInterface;
}
