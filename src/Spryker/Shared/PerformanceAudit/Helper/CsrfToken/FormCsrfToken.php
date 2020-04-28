<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Helper\CsrfToken;

use DOMDocument;
use DOMElement;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;

class FormCsrfToken implements CsrfTokenInterface
{
    protected const ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION = 'Csrf token element %s not found.';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $elementId;

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    protected $request;

    /**
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestInterface $request
     * @param string $url
     * @param string $elementId
     */
    public function __construct(RequestInterface $request, string $url, string $elementId)
    {
        $this->request = $request;
        $this->url = $url;
        $this->elementId = $elementId;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $response = $this->request->sendGetRequest($this->url);

        return $this->getElementFromResponse($response)
            ->getAttribute('value');
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\NoCsrfTokenElementException
     *
     * @return \DOMElement
     */
    protected function getElementFromResponse(ResponseInterface $response): DOMElement
    {
        $pageBody = new DOMDocument();
        libxml_use_internal_errors(true);

        $pageBody->loadHTML($response->getBody()->getContents());

        $csrfTokenElement = $pageBody->getElementById($this->elementId);

        if (!$csrfTokenElement) {
            throw new NoCsrfTokenElementException(sprintf(static::ERROR_MESSAGE_NO_CSRF_TOKEN_ELEMENT_EXCEPTION, $this->elementId));
        }

        return $csrfTokenElement;
    }
}
