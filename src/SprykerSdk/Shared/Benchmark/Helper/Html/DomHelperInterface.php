<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Helper\Html;

use DOMDocument;
use DOMElement;
use Psr\Http\Message\ResponseInterface;

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
    public function getElementById(DOMDocument $domDocument, string $elementId): DOMElement;
}
