<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Helper\Http;

use Spryker\Glue\PerformanceAudit\FactoryResolver\FactoryResolver;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface;

class HttpHelperFactory
{
    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface
     */
    public static function create(): HttpHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createHttpHelper();
    }
}
