<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\PerformanceAudit\Request\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

/**
 * @method \Spryker\Yves\PerformanceAudit\PerformanceAuditConfig getConfig()
 */
class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\PerformanceAudit\Request\Request
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
