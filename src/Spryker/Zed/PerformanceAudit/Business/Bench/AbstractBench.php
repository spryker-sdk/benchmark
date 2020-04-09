<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Bench;

use Spryker\Shared\PerformanceAudit\Bench\AbstractSharedBench;
use Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory;

class AbstractBench extends AbstractSharedBench
{
    protected const LOGIN_URL = '/login';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'loginForm__token';
    protected const LOGIN_EMAIL = 'spencor.hopkin@spryker.com';
    protected const LOGIN_PASSWORD = 'change123';

    /**
     * @return \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory
     */
    protected function getFactory(): PerformanceAuditBusinessFactory
    {
        return new PerformanceAuditBusinessFactory();
    }
}
