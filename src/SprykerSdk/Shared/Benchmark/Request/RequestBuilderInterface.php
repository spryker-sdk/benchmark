<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Request;

use Psr\Http\Message\RequestInterface;

interface RequestBuilderInterface
{
    /**
     * @var string
     */
    public const METHOD_GET = 'GET';
    /**
     * @var string
     */
    public const METHOD_POST = 'POST';
    /**
     * @var string
     */
    public const METHOD_DELETE = 'DELETE';
    /**
     * @var string
     */
    public const METHOD_PUT = 'PUT';
    /**
     * @var string
     */
    public const METHOD_PATCH = 'PATCH';

    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param mixed $body
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function buildRequest(string $method, string $uri, array $headers = [], $body = null): RequestInterface;
}
