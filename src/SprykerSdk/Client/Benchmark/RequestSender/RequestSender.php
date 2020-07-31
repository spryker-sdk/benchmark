<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Client\Benchmark\RequestSender;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Client\Benchmark\Dependency\Guzzle\BenchmarkToGuzzleClientInterface;
use SprykerSdk\Client\Benchmark\Exception\UnexpectedStatusCodeException;

class RequestSender implements RequestSenderInterface
{
    /**
     * @var \SprykerSdk\Client\Benchmark\Dependency\Guzzle\BenchmarkToGuzzleClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \SprykerSdk\Client\Benchmark\Dependency\Guzzle\BenchmarkToGuzzleClientInterface $guzzleClient
     */
    public function __construct(BenchmarkToGuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @throws \SprykerSdk\Client\Benchmark\Exception\UnexpectedStatusCodeException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [], int $expectedStatusCode = 200): ResponseInterface
    {
        $response = $this->guzzleClient->send($request, $options);

        if ($response->getStatusCode() !== $expectedStatusCode) {
            $message = sprintf('Unexpected status code `%s`, `%s` was expected', $response->getStatusCode(), $expectedStatusCode);

            throw new UnexpectedStatusCodeException($message);
        }

        return $response;
    }
}
