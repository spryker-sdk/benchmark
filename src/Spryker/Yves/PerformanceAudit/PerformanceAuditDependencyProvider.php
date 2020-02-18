<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use GuzzleHttp\Client;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;

/**
 * @method \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const GUZZLE_CLIENT = 'guzzle_client';
    public const FORM_CSRF_PROVIDER = 'form_csrf_provider';
    public const COOKIE_JAR = 'cookie_jar';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addGuzzleClient($container);
        $container = $this->addFormCsrfProvider($container);
        $container = $this->addCookieJar($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addGuzzleClient(Container $container)
    {
        $container[static::GUZZLE_CLIENT] = function (Container $container) {
            return new Client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addFormCsrfProvider(Container $container)
    {
        $container[static::FORM_CSRF_PROVIDER] = function (Container $container) {
            return (new Pimple())->getApplication()->get('form.csrf_provider');
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCookieJar(Container $container)
    {
        $container[static::COOKIE_JAR] = function (Container $container) {
            return new \GuzzleHttp\Cookie\CookieJar();
        };

        return $container;
    }
}
