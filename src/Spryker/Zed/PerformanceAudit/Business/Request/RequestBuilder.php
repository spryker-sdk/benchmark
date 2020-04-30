<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Request;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Spryker\Shared\PerformanceAudit\Exception\HttpMethodNotAllowed;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Zed\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface;
use Spryker\Zed\PerformanceAudit\PerformanceAuditConfig;

class RequestBuilder implements RequestBuilderInterface
{
    /**
     * @var string[]
     */
    protected $headers = [
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate',
    ];

    /**
     * @var \Spryker\Zed\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig
     */
    protected $performanceAuditConfig;

    /**
     * @param \Spryker\Zed\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface $utilEncodingService
     * @param \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig $performanceAuditConfig
     */
    public function __construct(
        PerformanceAuditToUtilEncodingServiceInterface $utilEncodingService,
        PerformanceAuditConfig $performanceAuditConfig
    ) {
        $this->utilEncodingService = $utilEncodingService;
        $this->performanceAuditConfig = $performanceAuditConfig;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param mixed $body
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function buildRequest(string $method, string $uri, array $headers = [], $body = null): RequestInterface
    {
        $this->assertMethod($method);

        return new Request(
            $method,
            $this->buildUri($uri),
            $this->buildHeaders($headers),
            $this->buildBody($body)
        );
    }

    /**
     * @param string $method
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\HttpMethodNotAllowed
     *
     * @return void
     */
    protected function assertMethod(string $method): void
    {
        $allowedMethods = [
            static::METHOD_POST,
            static::METHOD_GET,
            static::METHOD_DELETE,
            static::METHOD_PATCH,
            static::METHOD_PUT,
        ];

        if (!in_array($method, $allowedMethods, true)) {
            throw new HttpMethodNotAllowed(sprintf('Not allowed HTTP method `%s`', $method));
        }
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    protected function buildUri(string $uri): string
    {
        return sprintf('%s%s', $this->performanceAuditConfig->getRequestBaseUrl(), $uri);
    }

    /**
     * @param string[] $headers
     *
     * @return string[]
     */
    protected function buildHeaders(array $headers): array
    {
        $headers = array_merge($this->headers, $headers);

        return $headers;
    }

    /**
     * @param mixed $body
     *
     * @return mixed
     */
    protected function buildBody($body)
    {
        if (!$body) {
            return null;
        }

        if (is_array($body)) {
            return $this->utilEncodingService->encodeJson($body);
        }

        return $body;
    }
}
