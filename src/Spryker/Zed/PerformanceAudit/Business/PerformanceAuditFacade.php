<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory getFactory()
 */
class PerformanceAuditFacade extends AbstractFacade implements PerformanceAuditFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string|null $testDirectoryPath
     * @param int|null $iterations
     * @param int|null $revs
     *
     * @return int|null
     */
    public function runPhpBench(?string $testDirectoryPath = null, ?int $iterations = null, ?int $revs = null): ?int
    {
        return $this->getFactory()->createPhpBenchRunner()->run($testDirectoryPath, $iterations, $revs);
    }
}
