<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Exception\UnexpectedStatusCodeException;

class Request implements RequestInterface
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string[]
     */
    protected $headers;

    /**
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $baseUrl
     * @param string[] $headers
     */
    public function __construct(ClientInterface $client, string $baseUrl, array $headers = [])
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\UnexpectedStatusCodeException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(string $method, string $url, array $options, int $expectedStatusCode = 200): ResponseInterface
    {
        $response = $this->client->request($method, $this->baseUrl . $url, $this->buildOptions($options));

        if ($response->getStatusCode() !== $expectedStatusCode) {
            $message = sprintf('Unexpected status code \'%s\', \'%s\' was expected', $response->getStatusCode(), $expectedStatusCode);

            throw new UnexpectedStatusCodeException($message);
        }

        return $response;
    }

    /**
     * @param string $url
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendGetRequest(string $url, int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->sendRequest(RequestInterface::METHOD_GET, $url, [], $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPostRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        $body = $body ? ['body' => $body] : [];

        return $this->sendRequest(RequestInterface::METHOD_POST, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendDeleteRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->sendRequest(RequestInterface::METHOD_DELETE, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPutRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        $body = $body ? ['body' => $body] : [];

        return $this->sendRequest(RequestInterface::METHOD_PUT, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPatchRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        $body = $body ? ['body' => $body] : [];

        return $this->sendRequest(RequestInterface::METHOD_PATCH, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $headerName
     * @param string $headerValue
     *
     * @return $this
     */
    public function addHeader(string $headerName, string $headerValue)
    {
        $this->headers[$headerName] = $headerValue;

        return $this;
    }

    /**
     * @param string $headerName
     *
     * @return bool
     */
    public function hasHeader(string $headerName): bool
    {
        return isset($this->headers[$headerName]);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function buildOptions(array $options): array
    {
        if (!isset($options['headers'])) {
            $options['headers'] = $this->headers;
        }

        if (isset($options['body'])) {
            $options['body'] = json_encode($options['body']);
        }

        return $options;
    }
}
