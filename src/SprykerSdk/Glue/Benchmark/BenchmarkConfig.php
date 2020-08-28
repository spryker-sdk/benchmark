<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark;

use Spryker\Yves\Kernel\AbstractBundleConfig;
use SprykerSdk\Shared\Benchmark\BenchmarkConstants;

class BenchmarkConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(BenchmarkConstants::GLUE_APPLICATION_DOMAIN);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTestsDirectory(): string
    {
        return $this->getSharedConfig()->getTestsDirectory();
    }

    /**
     * @api
     *
     * @return int
     */
    public function getIterations(): int
    {
        return $this->getSharedConfig()->getIterations();
    }

    /**
     * @api
     *
     * @return int
     */
    public function getRevolutions(): int
    {
        return $this->getSharedConfig()->getRevolutions();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getReport(): string
    {
        return $this->getSharedConfig()->getReport();
    }
}
