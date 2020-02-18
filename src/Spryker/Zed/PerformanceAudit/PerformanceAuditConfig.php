<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit;

use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * Class PerformanceAuditConfig
 *
 * @package Spryker\Zed\PerformanceAudit
 */
class PerformanceAuditConfig extends AbstractBundleConfig
{
    public const APPLICATION_YVES = 'yves';
    public const APPLICATION_ZED = 'zed';
    public const APPLICATION_GLUE = 'glue';

    public const APPLICATIONS = [
        self::APPLICATION_YVES,
//        self::APPLICATION_ZED,
//        self::APPLICATION_GLUE
    ];

    /**
     * Gets path to application root directory.
     *
     * @return string
     */
    public function getPathToRoot(): string
    {
        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR;
    }

    /**
     * Gets path to project level test directory.
     *
     * @return string
     */
    public function getPathToProjectLevelTestDirectory($application): string
    {
        switch ($application) {
            case self::APPLICATION_YVES:
                return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PerformanceAudit/Yves';
                break;
            case self::APPLICATION_ZED:
                return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PerformanceAudit/Zed';
                break;
            case self::APPLICATION_GLUE:
                return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PerformanceAudit/Glue';
                break;
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @param string $application
     *
     * @return string
     */
    public function getPathToBootstrap(string $application): string
    {
        switch ($application) {
            case self::APPLICATION_YVES:
                return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Yves/PerformanceAudit/bootstrap.php';
                break;
            case self::APPLICATION_ZED:
                return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Zed/PerformanceAudit/bootstrap.php';
                break;
            case self::APPLICATION_GLUE:
                return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Glue/PerformanceAudit/bootstrap.php';
                break;
        }

        throw new \InvalidArgumentException();
    }
}
