<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench;

interface PhpBenchRunnerInterface
{
    /**
     * @param string|null $testDirectoryPath
     * @param int|null $iterations
     * @param int|null $revs
     *
     * @return int|null Exit code
     */
    public function run(?string $testDirectoryPath = null, ?int $iterations = null, ?int $revs = null): ?int;
}
