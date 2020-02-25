<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\PerformanceAudit\Request\Request;

/**
 * @method \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Glue\PerformanceAudit\Request\Request
     */
    public function createRequest(): Request
    {
        return new Request($this->getConfig(), $this->getGuzzleClient());
    }

    /**
     * @return mixed
     */
    public function getGuzzleClient()
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::GUZZLE_CLIENT);
    }
}
