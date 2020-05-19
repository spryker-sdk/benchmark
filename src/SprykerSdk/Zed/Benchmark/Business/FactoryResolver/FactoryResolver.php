<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\FactoryResolver;

use Spryker\Zed\Kernel\ClassResolver\Business\BusinessFactoryResolver;
use SprykerSdk\Zed\Benchmark\Business\BenchmarkBusinessFactory;

class FactoryResolver
{
    /**
     * @var \SprykerSdk\Zed\Benchmark\Business\BenchmarkBusinessFactory
     */
    protected $factory;

    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\BenchmarkBusinessFactory
     */
    public function getFactory(): BenchmarkBusinessFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\BenchmarkBusinessFactory
     */
    private function resolveFactory(): BenchmarkBusinessFactory
    {
        /** @var \SprykerSdk\Zed\Benchmark\Business\BenchmarkBusinessFactory $factory */
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
