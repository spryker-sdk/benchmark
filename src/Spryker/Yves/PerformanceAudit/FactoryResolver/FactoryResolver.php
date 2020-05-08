<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\FactoryResolver;

use Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver as KernelFactoryResolver;
use Spryker\Yves\PerformanceAudit\PerformanceAuditFactory;

class FactoryResolver
{
    /**
     * @var \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    protected $factory;

    /**
     * @return \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    public function getFactory(): PerformanceAuditFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    private function resolveFactory(): PerformanceAuditFactory
    {
        /** @var \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver(): KernelFactoryResolver
    {
        return new KernelFactoryResolver();
    }
}