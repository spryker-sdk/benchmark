<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark\PhpBench;

use SprykerSdk\Shared\Benchmark\PhpBench\AbstractPhpBenchRunner;
use SprykerSdk\Yves\Benchmark\BenchmarkConfig;

class PhpBenchRunner extends AbstractPhpBenchRunner
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
        return 'Yves';
    }

    /**
     * @return string
     */
    protected function getDefaultTestsDirectory(): string
    {
        return sprintf('%s/%s', $this->config->getTestsDirectory(), $this->getApplication());
    }
}
