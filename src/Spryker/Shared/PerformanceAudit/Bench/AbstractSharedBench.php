<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Bench;

use GuzzleHttp\Cookie\CookieJarInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;
use Spryker\Yves\PerformanceAudit\Request\Request;

class AbstractSharedBench
{
    protected const ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION = 'Csrf token element %s not found.';

    protected const COOKIE_DATA_INDEX = 1;

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
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     *
     * @return array|null
     */
    protected function getCookieDataFromCookieJar(CookieJarInterface $cookieJar): ?array
    {
        $data = $cookieJar->toArray();

        return $data[static::COOKIE_DATA_INDEX] ?? null;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    protected function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * @return string[]
     */
    protected function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $headerName
     *
     * @return bool
     */
    protected function hasHeader(string $headerName): bool
    {
        return isset($this->headers[$headerName]);
    }

    /**
     * @param string $url
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendGetRequest(string $url, int $expectedStatusCode = 200): ResponseInterface
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
    protected function sendPostRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->sendRequest(RequestInterface::METHOD_POST, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendDeleteRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
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
    protected function sendPutRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->sendRequest(RequestInterface::METHOD_PUT, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendPatchRequest(string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->sendRequest(RequestInterface::METHOD_PATCH, $url, $body, $expectedStatusCode);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $body
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest(string $method, string $url, array $body = [], int $expectedStatusCode = 200): ResponseInterface
    {
        $options = ['headers' => $this->getHeaders()];
        if ($body) {
            $options['body'] = json_encode($body);
        }

        return $this->getRequest()->sendRequest($method, $url, $options, $expectedStatusCode);
    }

    /**
     * @param string $url
     * @param string $elementId
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException
     *
     * @return string
     */
    protected function getCsrfToken(string $url, string $elementId): string
    {
        $response = $this->sendGetRequest($url);

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);

        $doc->loadHTML($response->getBody()->getContents());

        $csrfTokenElement = $doc->getElementById($elementId);

        if (!$csrfTokenElement) {
            throw new NoCsrfTokenElementException(sprintf(static::ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION, $elementId));
        }

        return $csrfTokenElement->getAttribute('value');
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    protected function getRequest(): RequestInterface
    {
        if ($this->request === null) {
            $this->request = $this->getFactory()->createRequest();
        }

        return $this->request;
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        if ($this->hasHeader('Cookie')) {
            return;
        }

        $cookieJar = $this->getFactory()->getCookieJar();
        $options = $this->buildLoginData($cookieJar);

        $this->getRequest()->sendRequest(Request::METHOD_POST, static::LOGIN_URL, $options, 200);
        $cookie = $this->getCookieDataFromCookieJar($cookieJar);

        if ($cookie) {
            $this->addHeader('Cookie', sprintf('%s=%s', $cookie['Name'], $cookie['Value']));
        }
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     *
     * @return array
     */
    protected function buildLoginData(CookieJarInterface $cookieJar): array
    {
        return [
            'headers' => $this->headers,
            'form_params' => [
                'loginForm' => [
                    'email' => static::LOGIN_EMAIL,
                    'password' => static::LOGIN_PASSWORD,
                    '_token' => $this->getCsrfToken(static::LOGIN_URL, static::LOGIN_CSRF_FORM_ELEMENT_ID),
                ],
            ],
            'cookies' => $cookieJar,
        ];
    }
}
