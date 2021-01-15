<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\GuiTable;

use SprykerSdk\Zed\Benchmark\Business\FactoryResolver\FactoryResolver;

class GuiTableHelperFactory
{
    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\Helper\GuiTable\GuiTableHelperInterface
     */
    public static function createGuiTableHelper(): GuiTableHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createGuiTableHelper();
    }
}
