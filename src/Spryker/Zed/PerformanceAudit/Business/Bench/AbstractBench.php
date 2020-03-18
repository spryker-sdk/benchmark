<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Bench;

use DOMDocument;
use GuzzleHttp\Cookie\CookieJarInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Bench\AbstractSharedBench;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;
use Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory;
use Spryker\Zed\PerformanceAudit\Business\Request\Request;

class AbstractBench extends AbstractSharedBench
{
    protected const COOKIE_DATA_INDEX = 1;

    /**
     * @param string $url
     * @param string $email
     * @param string $password
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function login(string $url, string $email, string $password): ResponseInterface
    {
        $cookieJar = $this->getCookieJar();
        $options = [
            'headers' => $this->headers,
            'form_params' => [
                'loginForm' => [
                    'email' => $email,
                    'password' => $password,
                    '_token' => $this->getCsrfToken($url, 'loginForm__token'),
                ],
            ],
            'cookies' => $cookieJar,
        ];

        $response = $this->getRequest()->sendRequest(Request::METHOD_POST, $url, $options, 200);
        $cookie = $this->getCookieDataFromCookieJar($cookieJar, static::COOKIE_DATA_INDEX);

        if ($cookie) {
            $this->addHeader('Cookie', $cookie['Name'] . '=' . $cookie['Value']);
        }

        return $response;
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param int $index
     *
     * @return array|null
     */
    protected function getCookieDataFromCookieJar(CookieJarInterface $cookieJar, int $index): ?array
    {
        $data = $cookieJar->toArray();

        if (isset($data[$index])) {
            return $data[$index];
        }

        return null;
    }

    /**
     * @param string $url
     * @param string $elementId
     *
     * @return string
     */
    protected function getCsrfToken(string $url, string $elementId): string
    {
        $response = $this->getRequest()
            ->sendRequest(Request::METHOD_GET, $url, ['headers' => $this->getHeaders()], 200);

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);

        $doc->loadHTML($response->getBody()->getContents());

        return $doc->getElementById($elementId)->getAttribute('value');
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    protected function getRequest(): RequestInterface
    {
        return $this->getFactory()->createRequest();
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    protected function getCookieJar(): CookieJarInterface
    {
        return $this->getFactory()->getCookieJar();
    }

    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    protected function getFactory(): PerformanceAuditBusinessFactory
    {
        return new PerformanceAuditBusinessFactory();
    }
}
