<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;

interface BenchmarkFacadeInterface
{
    /**
     * Specification:
     * - Runs PHPBench performance audit tool.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return int
     */
    public function runPhpBench(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): int;
}
