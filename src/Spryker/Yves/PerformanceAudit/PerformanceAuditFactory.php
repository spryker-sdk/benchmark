<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\PerformanceAudit\Request\Request;

/**
 * @method \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\PerformanceAudit\Request\Request
     */
    public function createRequest(): RequestInterface
    {
        return new Request($this->getConfig(), $this->getGuzzleClient());
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    public function getGuzzleClient(): ClientInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::CLIENT_GUZZLE);
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    public function getCookieJar(): CookieJar
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::COOKIE_JAR);
    }
}
