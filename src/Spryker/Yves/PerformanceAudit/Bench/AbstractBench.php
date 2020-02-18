<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Bench;

use GuzzleHttp\Cookie\CookieJar;
use Psr\Http\Message\ResponseInterface;
use Spryker\Yves\PerformanceAudit\PerformanceAuditFactory;
use Spryker\Yves\PerformanceAudit\Request\Request;

class AbstractBench
{
    /**
     * @var string
     */
    protected $cookie;

    /**
     * @var array
     */
    protected $headers = [
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate',
    ];

    /**
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    protected function addHeader(string $key, string $value): array
    {
        $this->headers[$key] = $value;

        return $this->headers;
    }

    /**
     * @return array
     */
    protected function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $url
     * @param string $email
     * @param string $password
     * @param int $expectedStatusCode
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(string $url, string $email, string $password, int $expectedStatusCode): ResponseInterface
    {
        $cookieJar = $this->getCookieJar();
        $options = [
            'headers' => $this->headers,
            'form_params' => [
                'email' => $email,
                'password' => $password
            ],
            'cookies' => $cookieJar,
        ];

        $response = $this->getRequest()->sendRequest(Request::METHOD_POST, $url, $options, 200);

        if ($response->getStatusCode() != $expectedStatusCode) {
            $msg = sprintf('Unexpected status code %s, %s was expected', $response->getStatusCode(), $expectedStatusCode);
            throw new \RuntimeException($msg);
        }

        $cookie = $cookieJar->toArray()[1];

        $this->addHeader('Cookie', $cookie['Domain'] . '=' . $cookie['Value']);

        return $response;
    }

    /**
     * @param $tokenId
     * @return mixed
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return string
     */
    public function getCsrfToken($tokenId): string
    {
        $token = $this->getFactory()->getFormCsrfProvider()->getToken($tokenId);

        return $token->getValue();
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\Request\Request
     *
     * @throws \Exception
     *
     * @return \Spryker\Yves\PerformanceAudit\Request\Request
     */
    public function getRequest(): Request
    {
        return $this->getFactory()->createRequest();
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJar
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    public function getCookieJar(): CookieJar
    {
        return $this->getFactory()->getCookieJar();
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    public function getFactory()
    {
        return new PerformanceAuditFactory();
    }
}
