<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Bench;

use Spryker\Shared\PerformanceAudit\Bench\AbstractSharedBench;
use Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver;
use Spryker\Yves\PerformanceAudit\PerformanceAuditFactory;

class AbstractBench extends AbstractSharedBench
{
    protected const LOGIN_URL = '/login';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'loginForm__token';
    protected const LOGIN_EMAIL = 'spencor.hopkin@spryker.com';
    protected const LOGIN_PASSWORD = 'change123';
    protected const LOGIN_FORM_NAME = 'loginForm';

    /**
     * @var \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    protected $factory;

    /**
     * @return \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory
     */
    protected function getFactory(): PerformanceAuditFactory
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
        /** @var \Spryker\Yves\PerformanceAudit\PerformanceAuditFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Yves\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver()
    {
        return new FactoryResolver();
    }
}
