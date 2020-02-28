<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Spryker\Shared\PerformanceAudit\Request\SharedRequest;
use Spryker\Yves\PerformanceAudit\PerformanceAuditConfig;

class Request extends SharedRequest
{
    /**
     * @var \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig $config
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
