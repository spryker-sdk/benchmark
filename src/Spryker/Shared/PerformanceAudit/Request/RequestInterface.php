<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Request;

use Psr\Http\Message\ResponseInterface;

interface RequestInterface
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(string $method, string $url, array $options, int $expectedStatusCode = 200): ResponseInterface;

    /**
     * @param string $url
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendGetRequest(string $url, int $expectedStatusCode = 200): ResponseInterface;

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPostRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface;

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendDeleteRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface;

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPutRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface;

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPatchRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface;

    /**
     * @param string $headerName
     * @param string $headerValue
     *
     * @return $this
     */
    public function addHeader(string $headerName, string $headerValue);

    /**
     * @param string $headerName
     *
     * @return bool
     */
    public function hasHeader(string $headerName): bool;
}
