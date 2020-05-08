<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use Spryker\Shared\PerformanceAudit\PerformanceAuditConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class PerformanceAuditConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(PerformanceAuditConstants::BASE_URL_YVES);
    }
}
