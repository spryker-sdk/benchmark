<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\Helper\Login;

use SprykerSdk\Glue\Benchmark\FactoryResolver\FactoryResolver;
use SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface;

class LoginHelperFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface
     */
    public static function create(): LoginHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createLoginHelper();
    }
}
