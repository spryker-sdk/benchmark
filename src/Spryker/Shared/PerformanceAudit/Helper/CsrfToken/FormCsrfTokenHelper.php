<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Helper\CsrfToken;

use DOMDocument;
use DOMElement;
use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use Psr\Http\Message\ResponseInterface;
use Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface;
use Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;

class FormCsrfTokenHelper implements CsrfTokenHelperInterface
{
    protected const ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION = 'Csrf token element %s not found.';

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface
     */
    protected $performanceAuditClient;

    /**
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface $requestBuilder
     * @param \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface $performanceAuditClient
     */
    public function __construct(
        RequestBuilderInterface $requestBuilder,
        PerformanceAuditClientInterface $performanceAuditClient
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->performanceAuditClient = $performanceAuditClient;
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

        return $this->performanceAuditClient->sendRequest($request);
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
