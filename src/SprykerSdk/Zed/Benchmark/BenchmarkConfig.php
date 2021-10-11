<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerSdk\Shared\Benchmark\BenchmarkConstants;

class BenchmarkConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const DEFAULT_REPORT_CONFIG = 'generator:"expression", cols:["benchmark", "subject", "best", "mean", "worst", "stdev", "revs", "its"]';
    /**
     * @var int
     */
    protected const DEFAULT_ITERATION_COUNT = 1;
    /**
     * @var int
     */
    protected const DEFAULT_REVOLUTION_COUNT = 1;
    /**
     * @var string
     */
    protected const DEFAULT_TIME_UNIT = 'milliseconds';

    /**
     * Specification:
     * - Defines the base application url.
     *
     * @api
     *
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(BenchmarkConstants::BASE_URL_ZED);
    }

    /**
     * Specification:
     * - Returns the default tests directory.
     *
     * @api
     *
     * @return string
     */
    public function getDefaultTestsDirectory(): string
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
        return static::DEFAULT_REPORT_CONFIG;
    }

    /**
     * Specification:
     * - Returns the default value for Benchmark iteration count.
     *
     * @api
     *
     * @return int
     */
    public function getDefaultIterationCount(): int
    {
        return static::DEFAULT_ITERATION_COUNT;
    }

    /**
     * Specification:
     * - Returns the default value for Benchmark revolutions count.
     *
     * @api
     *
     * @return int
     */
    public function getDefaultRevolutionCount(): int
    {
        return static::DEFAULT_REVOLUTION_COUNT;
    }

    /**
     * Specification:
     * - Returns the default time output format.
     *
     * @api
     *
     * @return string
     */
    public function getDefaultTimeUnit(): string
    {
        return static::DEFAULT_TIME_UNIT;
    }
}
