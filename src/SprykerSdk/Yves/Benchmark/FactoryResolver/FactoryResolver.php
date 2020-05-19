<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark\FactoryResolver;

use Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver as KernelFactoryResolver;
use SprykerSdk\Yves\Benchmark\BenchmarkFactory;

class FactoryResolver
{
    /**
     * @var \SprykerSdk\Yves\Benchmark\BenchmarkFactory
     */
    protected $factory;

    /**
     * @return \SprykerSdk\Yves\Benchmark\BenchmarkFactory
     */
    public function getFactory(): BenchmarkFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \SprykerSdk\Yves\Benchmark\BenchmarkFactory
     */
    private function resolveFactory(): BenchmarkFactory
    {
        /** @var \SprykerSdk\Yves\Benchmark\BenchmarkFactory $factory */
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
