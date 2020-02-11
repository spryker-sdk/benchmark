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
    /**
     * Gets path to application root directory.
     *
     * @return string
     */
    public function getPathToRoot()
    {
        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR;
    }

    /**
     * Gets path to project level test directory.
     *
     * @return string
     */
    public function getPathToProjectLevelTestDirectory()
    {
        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'tests/PhpBenchTest';
    }

    /**
     * @return string
     */
    public function getPathToDefaultConfig()
    {
        return $this->getPathToRoot() . 'vendor/spryker/spryker/Bundles/PerformanceAudit/src/Spryker/Zed/PerformanceAudit/phpbench.json';
    }
}
