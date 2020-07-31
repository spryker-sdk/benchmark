<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark;

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
        return $this->get(BenchmarkConstants::BASE_URL_YVES);
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
}
