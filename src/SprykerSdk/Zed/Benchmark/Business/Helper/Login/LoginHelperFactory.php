<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Login;

use GuzzleHttp\Cookie\CookieJarInterface;

use SprykerSdk\Zed\Benchmark\Business\FactoryResolver\FactoryResolver;

class LoginHelperFactory
{
    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\Helper\Login\LoginHelperInterface
     */
    public static function createLoginHelper(): LoginHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createLoginHelper();
    }

    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\Helper\Login\LoginHelperInterface
     */
    public static function createMerchantPortalLoginHelper(): LoginHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createMerchantPortalLoginHelper();
    }
}
