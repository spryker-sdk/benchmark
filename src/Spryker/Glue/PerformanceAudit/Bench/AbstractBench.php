<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Bench;

use Spryker\Glue\PerformanceAudit\PerformanceAuditFactory;
use Spryker\Glue\PerformanceAudit\Request\Request;
use Spryker\Shared\PerformanceAudit\Bench\SharedAbstractBench;

class AbstractBench extends SharedAbstractBench
{
    /**
     * @return \Spryker\Glue\PerformanceAudit\Request\Request
     */
    protected function getRequest(): Request
    {
        return $this->getFactory()->createRequest();
    }

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    protected function getFactory(): PerformanceAuditFactory
    {
        return new PerformanceAuditFactory();
    }
}
