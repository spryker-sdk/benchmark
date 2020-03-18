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
     * Gets path to application root directory.
     *
     * @return string
     */
    protected function getPathToRoot(): string
    {
        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string[]
     */
    public function getApplicationsList(): array
    {
        return [static::APPLICATION_YVES, static::APPLICATION_ZED, static::APPLICATION_GLUE];
    }

    /**
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(PerformanceAuditConstants::BASE_URL_ZED);
    }

    /**
     * @return string
     */
    public function getPathToYvesTests(): string
    {
        return $this->getPathToRoot() . 'tests/PerformanceAudit/Yves';
    }

    /**
     * @return string
     */
    public function getPathToZedTests(): string
    {
        return $this->getPathToRoot() . 'tests/PerformanceAudit/Zed';
    }

    /**
     * @return string
     */
    public function getPathToGlueTests(): string
    {
        return $this->getPathToRoot() . 'tests/PerformanceAudit/Glue';
    }

    /**
     * @return string
     */
    public function getYvesBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'tests/PerformanceAudit/Yves/bootstrap.php';
    }

    /**
     * @return string
     */
    public function getZedBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'tests/PerformanceAudit/Zed/bootstrap.php';
    }

    /**
     * @return string
     */
    public function getGlueBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'tests/PerformanceAudit/Glue/bootstrap.php';
    }
}
