<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Helper\CsrfToken;

use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use GuzzleHttp\Cookie\CookieJarInterface;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;
use SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

class FormCsrfTokenHelper implements CsrfTokenHelperInterface
{
    protected const ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION = 'Csrf token element %s not found.';

    /**
     * @var \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \SprykerSdk\Client\Benchmark\BenchmarkClientInterface
     */
    protected $performanceAuditClient;

    /**
     * @var \GuzzleHttp\Cookie\CookieJarInterface
     */
    protected $cookieJar;

    /**
     * @var \SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface
     */
    protected $domHelper;

    /**
     * @param \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface $requestBuilder
     * @param \SprykerSdk\Client\Benchmark\BenchmarkClientInterface $performanceAuditClient
     * @param \GuzzleHttp\Cookie\CookieJarInterface $cookieJar
     * @param \SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface $domHelper
     */
    public function __construct(
        RequestBuilderInterface $requestBuilder,
        BenchmarkClientInterface $performanceAuditClient,
        CookieJarInterface $cookieJar,
        DomHelperInterface $domHelper
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->performanceAuditClient = $performanceAuditClient;
        $this->cookieJar = $cookieJar;
        $this->domHelper = $domHelper;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer $csrfTokenConfigTransfer
     *
     * @return string
     */
    public function getToken(PhpBenchCsrfTokenConfigTransfer $csrfTokenConfigTransfer): string
    {
        $csrfTokenConfigTransfer
            ->requireUrl()
            ->requireElementId();

        $response = $this->sendRequest($csrfTokenConfigTransfer->getUrl());
        $domDocument = $this->domHelper->buildDOMDocumentFromResponse($response);

        return $this->domHelper
            ->getElementById($domDocument, $csrfTokenConfigTransfer->getElementId())
            ->getAttribute('value');
    }

    /**
     * @param string $url
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest(string $url): ResponseInterface
    {
        $request = $this->requestBuilder->buildRequest(RequestBuilderInterface::METHOD_GET, $url);
        $options = [
            'cookies' => $this->cookieJar,
        ];

        return $this->performanceAuditClient->sendRequest($request, $options);
    }
}
