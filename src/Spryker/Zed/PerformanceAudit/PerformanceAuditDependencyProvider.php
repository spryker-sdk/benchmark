<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit;

use GuzzleHttp\Cookie\CookieJar;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceBridge;

/**
 * @method \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';
    public const CLIENT_PERFORMANCE_AUDIT = 'CLIENT_PERFORMANCE_AUDIT';
    public const COOKIE_JAR = 'COOKIE_JAR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addPerformanceAuditClient($container);
        $container = $this->addCookieJar($container);
        $container = $this->addUtilEncodingService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPerformanceAuditClient(Container $container): Container
    {
        $container->set(static::CLIENT_PERFORMANCE_AUDIT, function (Container $container) {
            return $container->getLocator()->performanceAudit->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCookieJar(Container $container): Container
    {
        $container->set(static::COOKIE_JAR, function () {
            return new CookieJar();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new PerformanceAuditToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service()
            );
        });

        return $container;
    }
}
