<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\FactoryTrait;

use Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver;
use Spryker\Glue\PerformanceAudit\PerformanceAuditFactory;

trait FactoryTrait
{
    /**
     * @var \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    protected $factory;

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    protected function getFactory(): PerformanceAuditFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    private function resolveFactory()
    {
        /** @var \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver(): FactoryResolver
    {
        return new FactoryResolver();
    }
}
