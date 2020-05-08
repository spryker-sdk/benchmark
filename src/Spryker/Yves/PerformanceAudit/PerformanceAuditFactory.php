<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use GuzzleHttp\Cookie\CookieJarInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface;
use Spryker\Shared\PerformanceAudit\Helper\CsrfToken\FormCsrfTokenHelper;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelper;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface;
use Spryker\Yves\PerformanceAudit\Helper\Login\LoginHelper;
use Spryker\Yves\PerformanceAudit\Request\RequestBuilder;

/**
 * @method \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig getConfig()
 * @method \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface getClient()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface
     */
    public function createLoginHelper(): LoginHelperInterface
    {
        return new LoginHelper($this->getClient(), $this->createRequestBuilder(), $this->getCookieJar(), $this->createCsrfTokenHelper());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder($this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    public function createCsrfTokenHelper(): CsrfTokenHelperInterface
    {
        return new FormCsrfTokenHelper($this->createRequestBuilder(), $this->getClient());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface
     */
    public function createHttpHelper(): HttpHelperInterface
    {
        return new HttpHelper($this->getClient());
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    public function getCookieJar(): CookieJarInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::COOKIE_JAR);
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): PerformanceAuditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
