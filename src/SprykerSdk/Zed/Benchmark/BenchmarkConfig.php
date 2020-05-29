<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerSdk\Shared\Benchmark\BenchmarkConstants;

/**
 * @method \SprykerSdk\Shared\Benchmark\BenchmarkConfig getSharedConfig()
 */
class BenchmarkConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(BenchmarkConstants::BASE_URL_ZED);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTestsFolder(): string
    {
        return $this->getSharedConfig()->getTestsFolder();
    }
}
