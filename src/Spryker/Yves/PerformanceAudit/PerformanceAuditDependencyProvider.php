<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

/**
 * @method \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_GUZZLE = 'CLIENT_GUZZLE';
    public const COOKIE_JAR = 'COOKIE_JAR';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addGuzzleClient($container);
        $container = $this->addCookieJar($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addGuzzleClient(Container $container): Container
    {
        $container->set(static::CLIENT_GUZZLE, function (Container $container) {
            return new Client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCookieJar(Container $container): Container
    {
        $container->set(static::COOKIE_JAR, function (Container $container) {
            return new CookieJar();
        });

        return $container;
    }
}
