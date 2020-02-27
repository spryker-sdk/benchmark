<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Spryker\Shared\Kernel\AbstractBundleConfig;

/**
 * Class SharedRequest
 *
 * @package Spryker\Yves\PerformanceAudit\Request
 */
class SharedRequest
{
    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    /**
     * @var \Spryker\Shared\Kernel\AbstractBundleConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param \Spryker\Shared\Kernel\AbstractBundleConfig $config
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(AbstractBundleConfig $config, ClientInterface $client)
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
        $response = $this->client->request($method, $this->config->getRequestBaseUrl() . $url, $options);

        if ($response->getStatusCode() !== $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $response->getStatusCode(), $expectedStatusCode);

            throw new RuntimeException($msg);
        }

        return $response;
    }
}
