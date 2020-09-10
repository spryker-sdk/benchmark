<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class BenchmarkConfig extends AbstractSharedConfig
{
    protected const BENCHMARK_REPORT_CONFIG = 'generator: "table", cols:["benchmark", "subject", "best", "mean", "worst", "stdev", "revs", "its"]';
    protected const BENCHMARK_ITERATION_CONFIG = 1;
    protected const BENCHMARK_REVOLUTION_CONFIG = 1;

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
     * Specification:
     * - Returns the configuration to build the Benchmark report.
     *
     * @api
     *
     * @return string
     */
    public function getReport(): string
    {
        return static::BENCHMARK_REPORT_CONFIG;
    }

    /**
     * Specification:
     * - Returns the default value for Benchmark iteration count.
     *
     * @api
     *
     * @return int
     */
    public function getIterations(): int
    {
        return static::BENCHMARK_ITERATION_CONFIG;
    }

    /**
     * Specification:
     * - Returns the default value for Benchmark reevolutions count.
     *
     * @api
     *
     * @return int
     */
    public function getRevolutions(): int
    {
        return static::BENCHMARK_REVOLUTION_CONFIG;
    }
}
