<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit;

use InvalidArgumentException;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * Class PerformanceAuditConfig
 *
 * @package Spryker\Zed\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    protected const APPLICATION_YVES = 'yves';
    protected const APPLICATION_ZED = 'zed';
    protected const APPLICATION_GLUE = 'glue';

    public const APPLICATIONS = [
        self::APPLICATION_YVES,
        self::APPLICATION_ZED,
        self::APPLICATION_GLUE,
    ];

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
     * @param string $application
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getPathToProjectLevelTestDirectory(string $application): string
    {
        switch ($application) {
            case self::APPLICATION_YVES:
                return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PerformanceAudit/Yves';
            case self::APPLICATION_ZED:
                return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PerformanceAudit/Zed';
            case self::APPLICATION_GLUE:
                return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PerformanceAudit/Glue';
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
            case self::APPLICATION_YVES:
                return $this->getYvesBootstrapFilePath();
            case self::APPLICATION_ZED:
                return $this->getZedBootstrapFilePath();
            case self::APPLICATION_GLUE:
                return $this->getGlueBootstrapFilePath();
        }

        throw new InvalidArgumentException();
    }

    /**
     * @return string
     */
    public function getRequestBaseUrl(): string
    {
        return $this->get(ApplicationConstants::BASE_URL_ZED);
    }

    /**
     * @return string
     */
    public function getYvesBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Yves/PerformanceAudit/bootstrap.php';
    }

    /**
     * @return string
     */
    public function getZedBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Zed/PerformanceAudit/bootstrap.php';
    }

    /**
     * @return string
     */
    public function getGlueBootstrapFilePath(): string
    {
        return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Glue/PerformanceAudit/bootstrap.php';
    }
}
