<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Helper\Login;

use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Yves\PerformanceAudit\FactoryResolver\FactoryResolver;

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
