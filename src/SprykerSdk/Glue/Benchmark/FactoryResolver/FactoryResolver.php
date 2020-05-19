<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\FactoryResolver;

use Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver as KernelFactoryResolver;
use SprykerSdk\Glue\Benchmark\BenchmarkFactory;

class FactoryResolver
{
    /**
     * @var \SprykerSdk\Glue\Benchmark\BenchmarkFactory
     */
    protected $factory;

    /**
     * @return \SprykerSdk\Glue\Benchmark\BenchmarkFactory
     */
    public function getFactory(): BenchmarkFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \SprykerSdk\Glue\Benchmark\BenchmarkFactory
     */
    private function resolveFactory(): BenchmarkFactory
    {
        /** @var \SprykerSdk\Glue\Benchmark\BenchmarkFactory $factory */
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
