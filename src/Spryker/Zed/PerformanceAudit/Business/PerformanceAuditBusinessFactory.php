<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunner;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunnerInterface;
use Spryker\Zed\PerformanceAudit\Business\Request\Request;
use Spryker\Zed\PerformanceAudit\PerformanceAuditDependencyProvider;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

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
     * @return \Spryker\Zed\PerformanceAudit\Business\Request\Request
     */
    public function createRequest(): Request
    {
        return new Request($this->getConfig(), $this->getGuzzleClient());
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getGuzzleClient(): Client
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::GUZZLE_CLIENT);
    }

    /**
     * @return \Symfony\Component\Security\Csrf\CsrfTokenManager
     */
    public function getFormCsrfProvider(): CsrfTokenManager
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::FORM_CSRF_PROVIDER);
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    public function getCookieJar(): CookieJar
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::COOKIE_JAR);
    }
}
