<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Http;

use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface;
use SprykerSdk\Zed\Benchmark\Business\FactoryResolver\FactoryResolver;

class HttpHelperFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface
     */
    public static function createHttpHelper(): HttpHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createHttpHelper();
    }
}
