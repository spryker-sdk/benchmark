<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Login;

use Generated\Shared\Transfer\LoginHeaderTransfer;
use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use GuzzleHttp\Cookie\CookieJarInterface;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;
use SprykerSdk\Shared\Benchmark\Exception\LoginFailedException;
use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

class LoginHelper implements LoginHelperInterface
{
    protected const LOGIN_URL = '/security-gui/login';
    protected const LOGIN_POST_URL = '/login_check';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'auth__token';
    protected const LOGIN_FORM_NAME = 'auth';

    protected const COOKIE_DATA_INDEX = 0;

    /**
     * @var \SprykerSdk\Client\Benchmark\BenchmarkClientInterface
     */
    protected $performanceAuditClient;

    /**
     * @var \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \GuzzleHttp\Cookie\CookieJarInterface
     */
    protected $cookieJar;

    /**
     * @var \SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    protected $csrfToken;

    /**
     * @param \SprykerSdk\Client\Benchmark\BenchmarkClientInterface $performanceAuditClient
     * @param \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface $requestBuilder
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param \SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface $csrfToken
     */
    public function __construct(
        BenchmarkClientInterface $performanceAuditClient,
        RequestBuilderInterface $requestBuilder,
        CookieJarInterface $cookieJar,
        CsrfTokenHelperInterface $csrfToken
    ) {
        $this->performanceAuditClient = $performanceAuditClient;
        $this->requestBuilder = $requestBuilder;
        $this->cookieJar = $cookieJar;
        $this->csrfToken = $csrfToken;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function login(string $username, string $password): void
    {
        $request = $this->requestBuilder->buildRequest(
            RequestBuilderInterface::METHOD_POST,
            self::LOGIN_POST_URL
        );
        $options = $this->buildLoginOptions($this->cookieJar, $username, $password);

        $this->performanceAuditClient->sendRequest($request, $options);
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
                self::LOGIN_FORM_NAME => [
                    'username' => $email,
                    'password' => $password,
                    '_token' => $this->csrfToken->getToken($this->createCsrfTokenConfigurationTransfer()),
                ],
            ],
            'cookies' => $cookieJar,
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer
     */
    protected function createCsrfTokenConfigurationTransfer(): PhpBenchCsrfTokenConfigTransfer
    {
        return (new PhpBenchCsrfTokenConfigTransfer())
            ->setUrl(self::LOGIN_URL)
            ->setElementId(self::LOGIN_CSRF_FORM_ELEMENT_ID);
    }
}
