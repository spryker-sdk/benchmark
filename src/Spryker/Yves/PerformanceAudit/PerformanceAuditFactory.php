<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit;

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
     *
     * @throws \Exception
     */
    public function createRequest()
    {
        return new Request($this->getConfig(), $this->getGuzzleClient());
    }

    /**
     * @return mixed
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getGuzzleClient()
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::GUZZLE_CLIENT);
    }

    /**
     * @return \Symfony\Component\Security\Csrf\CsrfTokenManager
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getFormCsrfProvider()
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::FORM_CSRF_PROVIDER);
    }

    /**
     * @return mixed
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCookieJar()
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::COOKIE_JAR);
    }
}
