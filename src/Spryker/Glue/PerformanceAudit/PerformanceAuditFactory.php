<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use GuzzleHttp\ClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\PerformanceAudit\Request\Request;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;

/**
 * @method \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Glue\PerformanceAudit\Request\Request
     */
    public function createRequest(): RequestInterface
    {
        return new Request($this->getConfig(), $this->getGuzzleClient());
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getGuzzleClient(): ClientInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::CLIENT_GUZZLE);
    }
}
