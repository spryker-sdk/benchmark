<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Bench;

use Spryker\Shared\PerformanceAudit\Bench\AbstractSharedBench;
use Spryker\Zed\Kernel\ClassResolver\Business\BusinessFactoryResolver;
use Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory;

class AbstractBench extends AbstractSharedBench
{
    protected const LOGIN_URL = '/auth/login';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'auth__token';
    protected const LOGIN_EMAIL = 'admin@spryker.com';
    protected const LOGIN_PASSWORD = 'change123';
    protected const LOGIN_FORM_NAME = 'auth';

    /**
     * @var \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    protected $factory;

    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    protected function getFactory(): PerformanceAuditBusinessFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    private function resolveFactory()
    {
        /** @var \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Zed\Kernel\ClassResolver\Business\BusinessFactoryResolver
     */
    private function getFactoryResolver()
    {
        return new BusinessFactoryResolver();
    }
}
