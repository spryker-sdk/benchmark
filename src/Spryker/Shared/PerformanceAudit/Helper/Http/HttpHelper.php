<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Helper\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface;

class HttpHelper implements HttpHelperInterface
{
    /**
     * @var \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface
     */
    protected $performanceAuditClient;

    /**
     * @param \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface $performanceAuditClient
     */
    public function __construct(PerformanceAuditClientInterface $performanceAuditClient)
    {
        $this->performanceAuditClient = $performanceAuditClient;
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
        return $this->performanceAuditClient->sendRequest($request, $options, $expectedStatusCode);
    }
}
