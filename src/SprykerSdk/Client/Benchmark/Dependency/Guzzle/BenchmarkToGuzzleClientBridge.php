<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Client\Benchmark\Dependency\Guzzle;

use Psr\Http\Message\RequestInterface;

class BenchmarkToGuzzleClientBridge implements BenchmarkToGuzzleClientInterface
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \GuzzleHttp\ClientInterface $guzzleClient
     */
    public function __construct($guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        return $this->guzzleClient->send($request, $options);
    }
}
