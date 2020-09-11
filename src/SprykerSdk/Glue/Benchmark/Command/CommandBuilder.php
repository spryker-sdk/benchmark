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
    protected $benchmarkConfig;

    /**
     * @param \SprykerSdk\Glue\Benchmark\BenchmarkConfig $benchmarkConfig
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
        return 'Glue';
    }

    /**
     * @return string
     */
    protected function getApplicationTestsDirectory(): string
    {
        return sprintf('%s/%s', $this->benchmarkConfig->getTestsDirectory(), $this->getApplication());
    }
}
