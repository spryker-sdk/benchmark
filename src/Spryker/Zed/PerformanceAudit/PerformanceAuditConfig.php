<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit;

use InvalidArgumentException;
use Spryker\Shared\PerformanceAudit\PerformanceAuditConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @package Spryker\Zed\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    protected const APPLICATION_YVES = 'yves';
    protected const APPLICATION_ZED = 'zed';
    protected const APPLICATION_GLUE = 'glue';

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
     * @param string $application
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getPathToProjectLevelTestDirectory(string $application): string
    {
        switch ($application) {
            case static::APPLICATION_YVES:
                return $this->getPathToRoot() . 'tests/PerformanceAudit/Yves';
            case static::APPLICATION_ZED:
                return $this->getPathToRoot() . 'tests/PerformanceAudit/Zed';
            case static::APPLICATION_GLUE:
                return $this->getPathToRoot() . 'tests/PerformanceAudit/Glue';
        }

        throw new InvalidArgumentException();
    }

    /**
     * @param string $application
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getPathToBootstrap(string $application): string
    {
        switch ($application) {
            case static::APPLICATION_YVES:
                return $this->getYvesBootstrapFilePath();
            case static::APPLICATION_ZED:
                return $this->getZedBootstrapFilePath();
            case static::APPLICATION_GLUE:
                return $this->getGlueBootstrapFilePath();
        }

        throw new InvalidArgumentException();
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
    public function getYvesBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'vendor/spryker/performance-audit/src/Spryker/Yves/PerformanceAudit/bootstrap.php';
    }

    /**
     * @return string
     */
    public function getZedBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'vendor/spryker/performance-audit/src/Spryker/Zed/PerformanceAudit/bootstrap.php';
    }

    /**
     * @return string
     */
    public function getGlueBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'vendor/spryker/performance-audit/src/Spryker/Glue/PerformanceAudit/bootstrap.php';
    }
}
