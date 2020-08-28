<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\Command;

use SprykerSdk\Glue\Benchmark\BenchmarkConfig;
use SprykerSdk\Shared\Benchmark\Command\AbstractCommandBuilder;

class CommandBuilder extends AbstractCommandBuilder
{
    /**
     * @var \SprykerSdk\Glue\Benchmark\BenchmarkConfig
     */
    protected $config;

    /**
     * @param \SprykerSdk\Glue\Benchmark\BenchmarkConfig $config
     */
    public function __construct(BenchmarkConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    protected function getApplication(): string
    {
        return 'Glue';
    }

    /**
     * @return string
     */
    protected function getDefaultTestsDirectory(): string
    {
        return sprintf('%s/%s', $this->config->getTestsDirectory(), $this->getApplication());
    }

    /**
     * @return int
     */
    protected function getIterationConfig(): int
    {
        return $this->config->getIterations();
    }

    /**
     * @return int
     */
    protected function getRevolutionConfig(): int
    {
        return $this->config->getRevolutions();
    }

    /**
     * @return string
     */
    protected function getReportConfig(): string
    {
        return $this->config->getReport();
    }
}
