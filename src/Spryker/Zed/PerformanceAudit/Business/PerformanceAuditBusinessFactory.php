<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJarInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunner;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunnerInterface;
use Spryker\Zed\PerformanceAudit\PerformanceAuditDependencyProvider;

/**
 * @method \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunnerInterface
     */
    public function createPhpBenchRunner(): PhpBenchRunnerInterface
    {
        return new PhpBenchRunner($this->getConfig());
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getGuzzleClient(): ClientInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::CLIENT_GUZZLE);
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    public function getCookieJar(): CookieJarInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::COOKIE_JAR);
    }
}
