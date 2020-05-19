<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark\Helper\CsrfToken;

use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface;
use SprykerSdk\Yves\Benchmark\FactoryResolver\FactoryResolver;

class CsrfTokenHelperFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    public static function create(): CsrfTokenHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createCsrfTokenHelper();
    }
}
