<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\FactoryResolver;

use Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver as KernelFactoryResolver;
use Spryker\Glue\PerformanceAudit\PerformanceAuditFactory;

class FactoryResolver
{
    /**
     * @var \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    protected $factory;

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    public function getFactory(): PerformanceAuditFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    private function resolveFactory(): PerformanceAuditFactory
    {
        /** @var \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver(): KernelFactoryResolver
    {
        return new KernelFactoryResolver();
    }
}
