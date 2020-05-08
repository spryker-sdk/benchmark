<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface;
use Spryker\Glue\PerformanceAudit\Helper\Login\LoginHelper;
use Spryker\Glue\PerformanceAudit\Request\RequestBuilder;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelper;
use Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;

/**
 * @method \Spryker\Glue\PerformanceAudit\PerformanceAuditConfig getConfig()
 * @method \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface getClient()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface
     */
    public function createLoginHelper(): LoginHelperInterface
    {
        return new LoginHelper($this->getClient(), $this->createRequestBuilder(), $this->getUtilEncodingService());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder($this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Helper\Http\HttpHelperInterface
     */
    public function createHttpHelper(): HttpHelperInterface
    {
        return new HttpHelper($this->getClient());
    }

    /**
     * @return \Spryker\Glue\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): PerformanceAuditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
