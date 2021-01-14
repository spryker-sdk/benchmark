<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Helper\Html;

use DOMDocument;
use DOMElement;
use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;
use SprykerSdk\Shared\Benchmark\Exception\NoCsrfTokenElementException;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

interface DomHelperInterface
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \DOMDocument
     */
    public function buildDOMDocumentFromResponse(ResponseInterface $response): DOMDocument;

    /**
     * @param \DOMDocument $domDocument
     * @param string $tag
     *
     * @throws \SprykerSdk\Shared\Benchmark\Exception\NoDomElementException
     *
     * @return \DOMElement
     */
    public function getFirstElementByTag(DOMDocument $domDocument, string $tag): DOMElement;

    /**
     * @param \DOMDocument $domDocument
     * @param string $elementId
     *
     * @throws \SprykerSdk\Shared\Benchmark\Exception\NoDomElementException
     *
     * @return \DOMElement
     */
    public function getElementFromDomDocument(DOMDocument $domDocument, string $elementId): DOMElement;
}
