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
    public const APPLICATION_YVES = 'yves';
    public const APPLICATION_ZED = 'zed';
    public const APPLICATION_GLUE = 'glue';

    /**
     * @api
     *
     * @return string[]
     */
    public function getApplicationsList(): array
    {
        return [static::APPLICATION_YVES, static::APPLICATION_ZED, static::APPLICATION_GLUE];
    }

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

    /**
     * @api
     *
     * @return string
     */
    public function getYvesBootstrapFilePath(): string
    {
        return $this->getTestsFolder() . '/Yves/bootstrap.php';
    }

    /**
     * @api
     *
     * @return string
     */
    public function getZedBootstrapFilePath(): string
    {
        return $this->getTestsFolder() . '/Zed/bootstrap.php';
    }

    /**
     * @api
     *
     * @return string
     */
    public function getGlueBootstrapFilePath(): string
    {
        return $this->getTestsFolder() . '/Glue/bootstrap.php';
    }
}
