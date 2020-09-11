<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark\Command;

use SprykerSdk\Shared\Benchmark\Command\AbstractCommandBuilder;
use SprykerSdk\Yves\Benchmark\BenchmarkConfig;

class CommandBuilder extends AbstractCommandBuilder
{
    /**
     * @var \SprykerSdk\Yves\Benchmark\BenchmarkConfig
     */
    protected $benchmarkConfig;

    /**
     * @param \SprykerSdk\Yves\Benchmark\BenchmarkConfig $benchmarkConfig
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
        return 'Yves';
    }

    /**
     * @return string
     */
    protected function getApplicationTestsDirectory(): string
    {
        return sprintf('%s/%s', $this->benchmarkConfig->getTestsDirectory(), $this->getApplication());
    }
}
