<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit;

use Spryker\Shared\PerformanceAudit\PerformanceAuditConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @package Spryker\Zed\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(PerformanceAuditConstants::BASE_URL_ZED);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTestsFolder(): string
    {
        return APPLICATION_ROOT_DIR . '/tests/PerformanceAudit/';
    }
}
