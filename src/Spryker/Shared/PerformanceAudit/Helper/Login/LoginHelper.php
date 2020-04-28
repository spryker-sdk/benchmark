<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Helper\Login;

use GuzzleHttp\Cookie\CookieJarInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\FormCsrfToken;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;

class LoginHelper implements LoginHelperInterface
{
    protected const LOGIN_URL = '';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = '';
    protected const LOGIN_FORM_NAME = '';

    protected const COOKIE_DATA_INDEX = 1;

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    protected $request;

    /**
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface $requestBuilder
     */
    public function __construct(RequestBuilderInterface $requestBuilder)
    {
        $this->request = $requestBuilder->buildRequest();
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return void
     */
    public function login(string $email, string $password): void
    {
        if ($this->request->hasHeader('Cookie')) {
            return;
        }

        $cookieJar = $this->getFactory()->getCookieJar();
        $options = $this->buildLoginData($cookieJar, $email, $password);

        $this->request->sendRequest(RequestInterface::METHOD_POST, static::LOGIN_URL, $options, 200);
        $cookie = $this->getCookieDataFromCookieJar($cookieJar);

        if ($cookie) {
            $this->request->addHeader('Cookie', sprintf('%s=%s', $cookie['Name'], $cookie['Value']));
        }
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    protected function buildLoginData(CookieJarInterface $cookieJar, string $email, string $password): array
    {
        return [
            'form_params' => [
                static::LOGIN_FORM_NAME => [
                    'email' => $email,
                    'password' => $password,
                    '_token' => $this->createCsrfToken()->getToken(),
                ],
            ],
            'cookies' => $cookieJar,
        ];
    }

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
     * @return \Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenInterface
     */
    protected function createCsrfToken(): CsrfTokenInterface
    {
        return new FormCsrfToken($this->request, static::LOGIN_URL, static::LOGIN_CSRF_FORM_ELEMENT_ID);
    }
}
