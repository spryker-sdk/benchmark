<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Helper\CsrfToken;

use DOMDocument;
use DOMElement;
use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Zed\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface;

class FormCsrfTokenHelper implements CsrfTokenHelperInterface
{
    protected const ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION = 'Csrf token element %s not found.';

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \Spryker\Zed\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface $requestBuilder
     * @param \Spryker\Zed\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface $guzzleClient
     */
    public function __construct(
        RequestBuilderInterface $requestBuilder,
        PerformanceAuditToGuzzleClientInterface $guzzleClient
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->guzzleClient = $guzzleClient;
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
        $domDocument = $this->buildDOMDocumentFromResponse($response);

        return $this->getElementFromDomDocument($domDocument, $csrfTokenConfigTransfer->getElementId())
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

        return $this->guzzleClient->send($request);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \DOMDocument
     */
    protected function buildDOMDocumentFromResponse(ResponseInterface $response): DOMDocument
    {
        $pageBody = new DOMDocument();
        libxml_use_internal_errors(true);

        $pageBody->loadHTML($response->getBody()->getContents());

        return $pageBody;
    }

    /**
     * @param \DOMDocument $DOMDocument
     * @param string $elementId
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException
     *
     * @return \DOMElement
     */
    protected function getElementFromDomDocument(DOMDocument $DOMDocument, string $elementId): DOMElement
    {
        $csrfTokenElement = $DOMDocument->getElementById($elementId);

        if (!$csrfTokenElement) {
            throw new NoCsrfTokenElementException(sprintf(static::ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION, $elementId));
        }

        return $csrfTokenElement;
    }
}
