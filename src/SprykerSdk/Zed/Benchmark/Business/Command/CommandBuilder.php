<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Command;

use SprykerSdk\Shared\Benchmark\Command\AbstractCommandBuilder;
use SprykerSdk\Zed\Benchmark\BenchmarkConfig;

class CommandBuilder extends AbstractCommandBuilder
{
    /**
     * @var \SprykerSdk\Zed\Benchmark\BenchmarkConfig
     */
    protected $benchmarkConfig;

    /**
     * @param \SprykerSdk\Zed\Benchmark\BenchmarkConfig $benchmarkConfig
     */
    public function __construct(BenchmarkConfig $benchmarkConfig)
    {
        $this->benchmarkConfig = $benchmarkConfig;
    }

    /**
     * @return string
     */
    protected function getApplication(): string
    {
        return 'Zed';
    }

    /**
     * @return string
     */
    protected function getApplicationTestsDirectory(): string
    {
        return sprintf('%s/%s', $this->config->getTestsDirectory(), $this->getApplication());
    }
}
