<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

interface PerformanceAuditFacadeInterface
{
    /**
     * Specification:
     * - Runs PHPBench performance audit tool.
     *
     * @api
     *
     * @param string|null $testDirectoryPath
     * @param int|null $iterations
     * @param int|null $revs
     *
     * @return int|null
     */
    public function runPhpBench(?string $testDirectoryPath = null, ?int $iterations = null, ?int $revs = null): ?int;
}
