<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Client\Benchmark;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface BenchmarkClientInterface
{
    /**
     * Specification:
     * - Sends request via HTTP client.
     * - Throws an exception if status code in response is no the expected one.
     *
     * @api
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(RequestInterface $request, array $options = [], int $expectedStatusCode = 200): ResponseInterface;
}
