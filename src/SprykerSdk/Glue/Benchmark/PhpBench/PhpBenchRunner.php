<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\PhpBench;

use SprykerSdk\Glue\Benchmark\BenchmarkConfig;
use SprykerSdk\Shared\Benchmark\PhpBench\AbstractPhpBenchRunner;

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
    protected function getLayer(): string
    {
        return 'Glue';
    }

    /**
     * @return string
     */
    protected function getDefaultTestsFolder(): string
    {
        return sprintf('%s/%s', $this->config->getTestsFolder(), $this->getLayer());
    }
}
