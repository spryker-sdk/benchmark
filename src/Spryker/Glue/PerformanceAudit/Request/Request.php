<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Spryker\Glue\PerformanceAudit\PerformanceAuditConfig;
use Spryker\Shared\PerformanceAudit\Request\SharedRequest;

class Request extends SharedRequest
{
    /**
     * @var \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @param \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig $config
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
