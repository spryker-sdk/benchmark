<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Helper\CsrfToken;

use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface;
use Spryker\Yves\PerformanceAudit\FactoryResolver\FactoryResolver;

class CsrfTokenHelperFactory
{
    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    public static function create(): CsrfTokenHelperInterface
    {
        $factoryResolver = new FactoryResolver();
        $factory = $factoryResolver->getFactory();

        return $factory->createCsrfTokenHelper();
    }
}
