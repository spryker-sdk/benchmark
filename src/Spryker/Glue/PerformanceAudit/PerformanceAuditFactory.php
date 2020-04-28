<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use GuzzleHttp\ClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getGuzzleClient(): ClientInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::CLIENT_GUZZLE);
    }
}
