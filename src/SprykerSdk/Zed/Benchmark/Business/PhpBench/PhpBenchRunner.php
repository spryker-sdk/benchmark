<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\PhpBench;

use SprykerSdk\Shared\Benchmark\PhpBench\AbstractPhpBenchRunner;
use SprykerSdk\Zed\Benchmark\BenchmarkConfig;

class PhpBenchRunner extends AbstractPhpBenchRunner
{
    /**
     * @var \SprykerSdk\Zed\Benchmark\BenchmarkConfig
     */
    protected $config;

    /**
     * @param \SprykerSdk\Zed\Benchmark\BenchmarkConfig $config
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
        return 'Zed';
    }

    /**
     * @return string
     */
    protected function getDefaultTestsDirectory(): string
    {
        return sprintf('%s/%s', $this->config->getTestsDirectory(), $this->getApplication());
    }
}
