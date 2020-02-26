<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

/**
 * @package Spryker\Zed\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(ApplicationConstants::BASE_URL_YVES);
    }
}
