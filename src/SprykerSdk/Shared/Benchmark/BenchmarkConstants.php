<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface BenchmarkConstants
{
    /**
     * Specification:
     * - The domain name used for glue application.
     *
     * @api
     *
     * @uses \Spryker\Shared\GlueApplication::GLUE_APPLICATION_DOMAIN
     */
    public const GLUE_APPLICATION_DOMAIN = 'GLUE_APPLICATION_DOMAIN';

    /**
     * Specification:
     * - Base URL for Yves including scheme and port (e.g. http://www.de.demoshop.local:8080)
     *
     * @api
     *
     * @uses \Spryker\Shared\Application::BASE_URL_YVES
     */
    public const BASE_URL_YVES = 'APPLICATION:BASE_URL_YVES';

    /**
     * Specification:
     * - Base URL for Zed including scheme and port (e.g. http://zed.de.demoshop.local:9080)
     *
     * @api
     *
     * @uses \Spryker\Shared\Application::BASE_URL_ZED
     */
    public const BASE_URL_ZED = 'APPLICATION:BASE_URL_ZED';
}
