<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

/**
 * Class PerformanceAuditConfig
 *
 * @package Spryker\Glue\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    /**
     * @return mixed
     */
    public function getRequestBaseUrl()
    {
        return $this->get(GlueApplicationConstants::GLUE_APPLICATION_DOMAIN);
    }
}
