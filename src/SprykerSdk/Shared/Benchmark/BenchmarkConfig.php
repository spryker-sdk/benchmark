<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class BenchmarkConfig extends AbstractSharedConfig
{
    protected const DEFAULT_BENCHMARK_REPORT_CONFIG = 'generator: "table", cols:["benchmark", "subject", "best", "mean", "worst", "stdev", "revs", "its"]';
    protected const DEFAULT_BENCHMARK_ITERATION_COUNT = 1;
    protected const DEFAULT_BENCHMARK_REVOLUTION_COUNT = 1;

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
    public function getDefaultReportConfig(): string
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
    public function getDefaultIterationsConfig(): int
    {
        return static::DEFAULT_BENCHMARK_ITERATION_COUNT;
    }

    /**
     * Specification:
     * - Returns the default value for Benchmark reevolutions count.
     *
     * @api
     *
     * @return int
     */
    public function getDefaultRevolutionsConfig(): int
    {
        return static::DEFAULT_BENCHMARK_REVOLUTION_COUNT;
    }
}
