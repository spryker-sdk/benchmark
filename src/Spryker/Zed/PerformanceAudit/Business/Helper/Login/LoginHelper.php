<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Helper\Login;

use Generated\Shared\Transfer\LoginHeaderTransfer;
use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use GuzzleHttp\Cookie\CookieJarInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Zed\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface;

class LoginHelper implements LoginHelperInterface
{
    protected const LOGIN_URL = '/auth/login';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'auth__token';
    protected const LOGIN_FORM_NAME = 'auth';

    protected const COOKIE_DATA_INDEX = 1;

    /**
     * @var \Spryker\Zed\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface
     */
    protected $guzzleClient;

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \GuzzleHttp\Cookie\CookieJarInterface
     */
    protected $cookieJar;

    /**
     * @var \Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    protected $csrfToken;

    /**
     * @param \Spryker\Zed\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface $guzzleClient
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface $requestBuilder
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param \Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface $csrfToken
     */
    public function __construct(
        PerformanceAuditToGuzzleClientInterface $guzzleClient,
        RequestBuilderInterface $requestBuilder,
        CookieJarInterface $cookieJar,
        CsrfTokenHelperInterface $csrfToken
    ) {

        $this->guzzleClient = $guzzleClient;
        $this->requestBuilder = $requestBuilder;
        $this->cookieJar = $cookieJar;
        $this->csrfToken = $csrfToken;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return \Generated\Shared\Transfer\LoginHeaderTransfer|null
     */
    public function login(string $email, string $password): ?LoginHeaderTransfer
    {
        $request = $this->requestBuilder->buildRequest(RequestBuilderInterface::METHOD_POST, static::LOGIN_URL);
        $options = $this->buildLoginOptions($this->cookieJar, $email, $password);

        $this->guzzleClient->send($request, $options);

        return $this->getLoginHeaderFromCookieJar($this->cookieJar);
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    protected function buildLoginOptions(CookieJarInterface $cookieJar, string $email, string $password): array
    {
        return [
            'form_params' => [
                static::LOGIN_FORM_NAME => [
                    'email' => $email,
                    'password' => $password,
                    '_token' => $this->csrfToken->getToken($this->createCsrfTokenConfigurationTransfer()),
                ],
            ],
            'cookies' => $cookieJar,
        ];
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     *
     * @return \Generated\Shared\Transfer\LoginHeaderTransfer|null
     */
    protected function getLoginHeaderFromCookieJar(CookieJarInterface $cookieJar): ?LoginHeaderTransfer
    {
        $data = $cookieJar->toArray();

        $data = $data[static::COOKIE_DATA_INDEX] ?? null;

        if (!$data) {
            return null;
        }

        return (new LoginHeaderTransfer())
            ->setName($data['Name'])
            ->setValue($data['Value']);
    }

    /**
     * @return \Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer
     */
    protected function createCsrfTokenConfigurationTransfer(): PhpBenchCsrfTokenConfigTransfer
    {
        return (new PhpBenchCsrfTokenConfigTransfer())
            ->setUrl(static::LOGIN_URL)
            ->setElementId(static::LOGIN_CSRF_FORM_ELEMENT_ID);
    }
}
