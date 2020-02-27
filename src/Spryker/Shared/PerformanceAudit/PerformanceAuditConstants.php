<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface PerformanceAuditConstants
{
    /**
     * @uses \Spryker\Shared\GlueApplication::GLUE_APPLICATION_DOMAIN
     */
    public const GLUE_APPLICATION_DOMAIN = 'GLUE_APPLICATION_DOMAIN';

    /**
     * @uses \Spryker\Shared\Application::BASE_URL_YVES
     */
    public const BASE_URL_YVES = 'APPLICATION:BASE_URL_YVES';

    /**
     * @uses \Spryker\Shared\Application::BASE_URL_ZED
     */
    public const BASE_URL_ZED = 'APPLICATION:BASE_URL_ZED';
}
