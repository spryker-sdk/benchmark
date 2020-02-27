<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Bench;

use DOMDocument;
use GuzzleHttp\Cookie\CookieJar;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Bench\SharedAbstractBench;
use Spryker\Yves\PerformanceAudit\PerformanceAuditFactory;
use Spryker\Yves\PerformanceAudit\Request\Request;

class AbstractBench extends SharedAbstractBench
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
        $loginFormPageResponse = $this->getRequest()
            ->sendRequest(Request::METHOD_GET, $url, ['headers' => $this->headers], 200);

        $cookieJar = $this->getCookieJar();
        $options = [
            'headers' => $this->headers,
            'form_params' => [
                'loginForm' => [
                    'email' => $email,
                    'password' => $password,
                    '_token' => $this->getCsrfToken($loginFormPageResponse->getBody()->getContents(), 'loginForm__token'),
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
     * @param \GuzzleHttp\Cookie\CookieJar $cookieJar
     * @param int $index
     *
     * @return array|null
     */
    protected function getCookieDataFromCookieJar(CookieJar $cookieJar, int $index): ?array
    {
        $data = $cookieJar->toArray();

        if (isset($data[$index])) {
            return $data[$index];
        }

        return null;
    }

    /**
     * @param string $content
     * @param string $elementId
     *
     * @return string
     */
    protected function getCsrfToken(string $content, string $elementId): string
    {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);

        $doc->loadHTML($content);

        return $doc->getElementById($elementId)->getAttribute('value');
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\Request\Request
     */
    protected function getRequest(): Request
    {
        return $this->getFactory()->createRequest();
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    protected function getCookieJar(): CookieJar
    {
        return $this->getFactory()->getCookieJar();
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    protected function getFactory(): PerformanceAuditFactory
    {
        return new PerformanceAuditFactory();
    }
}
