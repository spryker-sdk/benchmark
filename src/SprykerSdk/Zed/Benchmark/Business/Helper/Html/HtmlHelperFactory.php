<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Html;

use SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface;
use SprykerSdk\Zed\Benchmark\Business\FactoryResolver\FactoryResolver;

class HtmlHelperFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface
     */
    public static function createDomHelper(): DomHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createDomHelper();
    }
}
