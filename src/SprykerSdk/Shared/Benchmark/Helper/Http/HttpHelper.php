<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Helper\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;

class HttpHelper implements HttpHelperInterface
{
    /**
     * @var \SprykerSdk\Client\Benchmark\BenchmarkClientInterface
     */
    protected $benchmarkClient;

    /**
     * @param \SprykerSdk\Client\Benchmark\BenchmarkClientInterface $benchmarkClient
     */
    public function __construct(BenchmarkClientInterface $benchmarkClient)
    {
        $this->benchmarkClient = $benchmarkClient;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [], int $expectedStatusCode = 200): ResponseInterface
    {
        return $this->benchmarkClient->sendRequest($request, $options, $expectedStatusCode);
    }
}
