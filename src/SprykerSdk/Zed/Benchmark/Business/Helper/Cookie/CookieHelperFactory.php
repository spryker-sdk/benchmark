<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Cookie;

use GuzzleHttp\Cookie\CookieJarInterface;
use SprykerSdk\Zed\Benchmark\Business\FactoryResolver\FactoryResolver;

class CookieHelperFactory
{
    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    public static function getCookieJar(): CookieJarInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->getCookieJar();
    }
}
