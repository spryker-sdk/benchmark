<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunner;

/**
 * @method \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunnerInterface
     */
    public function createPhpBenchRunner()
    {
        return new PhpBenchRunner(
            $this->getConfig()
        );
    }
}
