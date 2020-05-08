<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Helper\Login;

use Spryker\Glue\PerformanceAudit\FactoryResolver\FactoryResolver;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;

class LoginHelperFactory
{
    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface
     */
    public static function create(): LoginHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createLoginHelper();
    }
}
