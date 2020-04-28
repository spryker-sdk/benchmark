<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\FactoryTrait;

use Spryker\Zed\Kernel\ClassResolver\Business\BusinessFactoryResolver;
use Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory;

trait FactoryTrait
{
    /**
     * @var \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    protected $factory;

    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    protected function getFactory(): PerformanceAuditBusinessFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    private function resolveFactory(): PerformanceAuditBusinessFactory
    {
        /** @var \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Zed\Kernel\ClassResolver\Business\BusinessFactoryResolver
     */
    private function getFactoryResolver(): BusinessFactoryResolver
    {
        return new BusinessFactoryResolver();
    }
}
