<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Request;

use Spryker\Glue\PerformanceAudit\FactoryResolver\FactoryResolver;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;

class RequestBuilderFactory
{
    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    public static function create(): RequestBuilderInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createRequestBuilder();
    }
}
