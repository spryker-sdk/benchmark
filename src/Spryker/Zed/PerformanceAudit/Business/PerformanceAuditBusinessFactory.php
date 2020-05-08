<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

use GuzzleHttp\Cookie\CookieJarInterface;
use Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\FormCsrfTokenHelper;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelper;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PerformanceAudit\Business\Helper\Login\LoginHelper;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunner;
use Spryker\Zed\PerformanceAudit\Business\PhpBench\PhpBenchRunnerInterface;
use Spryker\Zed\PerformanceAudit\Business\Request\RequestBuilder;
use Spryker\Zed\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface;
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
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder($this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface
     */
    public function createLoginHelper(): LoginHelperInterface
    {
        return new LoginHelper(
            $this->getPerformanceAuditClient(),
            $this->createRequestBuilder(),
            $this->getCookieJar(),
            $this->createCsrfTokenHelper()
        );
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface
     */
    public function createHttpHelper(): HttpHelperInterface
    {
        return new HttpHelper($this->getPerformanceAuditClient());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    public function createCsrfTokenHelper(): CsrfTokenHelperInterface
    {
        return new FormCsrfTokenHelper($this->createRequestBuilder(), $this->getPerformanceAuditClient());
    }

    /**
     * @return \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface
     */
    public function getPerformanceAuditClient(): PerformanceAuditClientInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::CLIENT_PERFORMANCE_AUDIT);
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    public function getCookieJar(): CookieJarInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::COOKIE_JAR);
    }

    /**
     * @return \Spryker\Zed\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): PerformanceAuditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
