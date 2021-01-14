<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\DataTable;

use GuzzleHttp\Cookie\CookieJarInterface;
use SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface;
use SprykerSdk\Zed\Benchmark\Business\FactoryResolver\FactoryResolver;

class DataTableHelperFactory
{
    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\Helper\DataTable\DataTableHelperInterface
     */
    public static function createDataTableHelper(): DataTableHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createDataTableHelper();
    }
}
