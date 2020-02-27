<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Request;

use GuzzleHttp\ClientInterface;
use Spryker\Shared\PerformanceAudit\Request\SharedRequest;
use Spryker\Zed\PerformanceAudit\PerformanceAuditConfig;

class Request extends SharedRequest
{
    /**
     * @var \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig $config
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(PerformanceAuditConfig $config, ClientInterface $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @return string
     */
    protected function getRequestBaseUrl(): string
    {
        return $this->config->getRequestBaseUrl();
    }
}
