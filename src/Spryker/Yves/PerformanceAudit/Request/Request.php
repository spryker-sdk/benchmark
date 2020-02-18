<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Request;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Spryker\Yves\PerformanceAudit\PerformanceAuditConfig;

/**
 * Class Request
 *
 * @package Spryker\Yves\PerformanceAudit\Request
 */
class Request
{
    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    /**
     * @var \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig $config
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(PerformanceAuditConfig $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

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
        if ($method == self::METHOD_GET) {
            $response = $this->client->get($this->config->getRequestBaseUrl() . $url, $options);
        } else {
            $response = $this->client->post($this->config->getRequestBaseUrl() . $url, $options);
        }

        if ($response->getStatusCode() != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $response->getStatusCode(), $expectedStatusCode);
            throw new RuntimeException($msg);
        }

        return $response;
    }
}
