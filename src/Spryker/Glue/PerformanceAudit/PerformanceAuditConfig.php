<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use Spryker\Shared\PerformanceAudit\PerformanceAuditConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

/**
 * @package Spryker\Glue\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(PerformanceAuditConstants::GLUE_APPLICATION_DOMAIN);
    }
}
