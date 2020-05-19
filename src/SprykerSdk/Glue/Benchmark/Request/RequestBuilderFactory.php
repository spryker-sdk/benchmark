<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\Request;

use SprykerSdk\Glue\Benchmark\FactoryResolver\FactoryResolver;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

class RequestBuilderFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    public static function create(): RequestBuilderInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createRequestBuilder();
    }
}
