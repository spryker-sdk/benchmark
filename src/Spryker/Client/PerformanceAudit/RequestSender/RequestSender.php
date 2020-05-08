<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\PerformanceAudit\RequestSender;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Client\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface;
use Spryker\Client\PerformanceAudit\Exception\UnexpectedStatusCodeException;

class RequestSender implements RequestSenderInterface
{
    /**
     * @var \Spryker\Client\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \Spryker\Client\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface $guzzleClient
     */
    public function __construct(PerformanceAuditToGuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @throws \Spryker\Client\PerformanceAudit\Exception\UnexpectedStatusCodeException
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
