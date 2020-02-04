<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench\Extension;

use PhpBench\DependencyInjection\Container;
use PhpBench\DependencyInjection\ExtensionInterface;
use PhpBench\Extension\CoreExtension;

/**
 * Class TtfbExtension
 *
 * @package Spryker\Zed\PerformanceAudit\Business\PhpBench\Extensio
 */
class TtfbExtension implements ExtensionInterface
{
    /**
     * @return array
     */
    public function getDefaultConfig()
    {
        // default configuration for this extension
        return [
            'executors' => ['ttfb'],
        ];
    }

    /**
     * @param \PhpBench\DependencyInjection\Container $container
     *
     * @return void
     */
    public function load(Container $container)
    {
        $container->register('benchmark.executor.ttfb', function (Container $container) {
            return new TtfbExecutor(
                $container->get(CoreExtension::SERVICE_REMOTE_LAUNCHER)
            );
        }, [CoreExtension::TAG_EXECUTOR => ['name' => 'ttfb']]);
    }

    /**
     * @param \PhpBench\DependencyInjection\Container $container
     *
     * @return void
     */
    public function build(Container $container)
    {
        $container->setParameter('executors', [12, 3]);
    }
}
