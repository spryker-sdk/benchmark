<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Client\Benchmark;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerSdk\Client\Benchmark\BenchmarkFactory getFactory()
 */
class BenchmarkClient extends AbstractClient implements BenchmarkClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(RequestInterface $request, array $options = [], int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->getFactory()
            ->createRequestSender()
            ->send($request, $options, $expectedStatusCode);
    }
}
