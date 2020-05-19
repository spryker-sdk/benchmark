<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark;

use SprykerSdk\Shared\Benchmark\BenchmarkConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

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
}
