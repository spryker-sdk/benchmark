<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Helper\Html;

use DOMDocument;
use DOMElement;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Shared\Benchmark\Exception\NoDomElementException;

class DomHelper implements DomHelperInterface
{
    protected const ERROR_MESSAGE_NO_DOM_ELEMENT_BY_ID_EXCEPTION = 'DOM element not found by id "%s".';
    protected const ERROR_MESSAGE_NO_DOM_ELEMENT_BY_TAG_EXCEPTION = 'DOM element(s) not found by tag "%s".';

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \DOMDocument
     */
    public function buildDOMDocumentFromResponse(ResponseInterface $response): DOMDocument
    {
        $pageBody = new DOMDocument();
        libxml_use_internal_errors(true);

        $htmlContent = $response->getBody()->getContents();
        $pageBody->loadHTML($htmlContent);

        return $pageBody;
    }

    /**
     * @param \DOMDocument $domDocument
     * @param string $tag
     *
     * @throws \SprykerSdk\Shared\Benchmark\Exception\NoDomElementException
     *
     * @return \DOMElement
     */
    public function getFirstElementByTag(DOMDocument $domDocument, string $tag): DOMElement
    {
        $domNodeList = $domDocument->getElementsByTagName($tag);
        if ($domNodeList->length === 0) {
            throw new NoDomElementException(
                sprintf(static::ERROR_MESSAGE_NO_DOM_ELEMENT_BY_TAG_EXCEPTION, $tag)
            );
        }

        return $domNodeList->item(0);
    }

    /**
     * @param \DOMDocument $domDocument
     * @param string $elementId
     *
     * @throws \SprykerSdk\Shared\Benchmark\Exception\NoDomElementException
     *
     * @return \DOMElement
     */
    public function getElementById(DOMDocument $domDocument, string $elementId): DOMElement
    {
        $domElement = $domDocument->getElementById($elementId);

        if (!$domElement) {
            throw new NoDomElementException(
                sprintf(static::ERROR_MESSAGE_NO_DOM_ELEMENT_BY_ID_EXCEPTION, $elementId)
            );
        }

        return $domElement;
    }
}
