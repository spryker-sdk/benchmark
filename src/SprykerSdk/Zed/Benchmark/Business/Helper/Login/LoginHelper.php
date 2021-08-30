<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Login;

use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use GuzzleHttp\Cookie\CookieJarInterface;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;
use SprykerSdk\Shared\Benchmark\Exception\LoginFailedException;
use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

class LoginHelper implements LoginHelperInterface
{
    protected const LOGIN_URL = '/security-gui/login';
    protected const LOGIN_POST_URL = '/login_check';

    protected const LOGIN_FORM_NAME = 'auth';
    protected const LOGIN_FORM_FIELD_USERNAME = 'username';
    protected const LOGIN_FORM_FIELD_PASSWORD = 'password';
    protected const LOGIN_FORM_FIELD_TOKEN = '_token';

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
            static::LOGIN_POST_URL
        );
        $options = $this->buildLoginOptions($this->cookieJar, $username, $password);

        $respsonse = $this->performanceAuditClient->sendRequest($request, $options);
        $this->validateLoginSuccess($respsonse);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \SprykerSdk\Shared\Benchmark\Exception\LoginFailedException
     *
     * @return void
     */
    protected function validateLoginSuccess(ResponseInterface $response): void
    {
        $responseContent = $response->getBody()->getContents();
        $searchPattern = sprintf('name="%s"', static::LOGIN_FORM_NAME);
        if (stripos($responseContent, $searchPattern) !== false) {
            throw new LoginFailedException('Failed to log in.');
        }
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    protected function buildLoginOptions(CookieJarInterface $cookieJar, string $username, string $password): array
    {
        $csrfToken = $this->csrfToken
            ->getToken($this->createCsrfTokenConfigurationTransfer());

        return [
            'form_params' => [
                static::LOGIN_FORM_NAME => [
                    static::LOGIN_FORM_FIELD_USERNAME => $username,
                    static::LOGIN_FORM_FIELD_PASSWORD => $password,
                    static::LOGIN_FORM_FIELD_TOKEN => $csrfToken,
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
        $tokenElementId = sprintf(
            '%s_%s',
            static::LOGIN_FORM_NAME,
            static::LOGIN_FORM_FIELD_TOKEN
        );

        return (new PhpBenchCsrfTokenConfigTransfer())
            ->setUrl(static::LOGIN_URL)
            ->setElementId($tokenElementId);
    }
}
