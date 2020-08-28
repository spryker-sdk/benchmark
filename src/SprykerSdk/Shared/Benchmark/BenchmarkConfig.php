<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class BenchmarkConfig extends AbstractSharedConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getTestsDirectory(): string
    {
        return APPLICATION_ROOT_DIR . '/tests/Benchmark/';
    }

    /**
     * @api
     *
     * @return string
     */
    public function getReport(): string
    {
        return 'generator: "table", cols:["benchmark", "subject", "best", "mean", "worst", "stdev", "revs", "its"]';
    }

    /**
     * @api
     *
     * @return int
     */
    public function getIterations(): int
    {
        return 1;
    }

    /**
     * @api
     *
     * @return int
     */
    public function getRevolutions(): int
    {
        return 1;
    }
}
