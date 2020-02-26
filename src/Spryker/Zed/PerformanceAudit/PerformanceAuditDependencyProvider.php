<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Communication\Plugin\Pimple;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const GUZZLE_CLIENT = 'guzzle_client';
    public const FORM_CSRF_PROVIDER = 'form_csrf_provider';
    public const COOKIE_JAR = 'cookie_jar';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addGuzzleClient($container);
        $container = $this->addFormCsrfProvider($container);
        $container = $this->addCookieJar($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGuzzleClient(Container $container): Container
    {
        $container[static::GUZZLE_CLIENT] = function (Container $container) {
            return new Client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFormCsrfProvider(Container $container): Container
    {
        $container[static::FORM_CSRF_PROVIDER] = function (Container $container) {
            return (new Pimple())->getApplication()->get('form.csrf_provider');
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCookieJar(Container $container): Container
    {
        $container[static::COOKIE_JAR] = function (Container $container) {
            return new CookieJar();
        };

        return $container;
    }
}
