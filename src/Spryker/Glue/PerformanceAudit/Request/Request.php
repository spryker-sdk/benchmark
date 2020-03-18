<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Spryker\Glue\PerformanceAudit\PerformanceAuditConfig;
use Spryker\Shared\PerformanceAudit\Request\AbstractSharedRequest;

class Request extends AbstractSharedRequest
{
    /**
     * @var \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig $config
     * @param \GuzzleHttp\ClientInterface $guzzleClient
     */
    public function __construct(PerformanceAuditConfig $config, ClientInterface $guzzleClient)
    {
        $this->config = $config;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function getClient(): ClientInterface
    {
        return $this->guzzleClient;
    }

    /**
     * @return string
     */
    protected function getRequestBaseUrl(): string
    {
        return $this->config->getRequestBaseUrl();
    }
}
