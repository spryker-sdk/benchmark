<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use GuzzleHttp\Client;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

/**
 * @method \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_GUZZLE = 'CLIENT_GUZZLE';
    public const COOKIE_JAR = 'cookie_jar';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addGuzzleClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addGuzzleClient(Container $container): Container
    {
        $container->set(static::CLIENT_GUZZLE, function (Container $container) {
            return new Client();
        });

        return $container;
    }
}
