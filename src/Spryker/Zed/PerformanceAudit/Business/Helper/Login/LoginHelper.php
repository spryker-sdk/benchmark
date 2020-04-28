<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\Helper\Login;

use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelper as SharedLoginHelper;
use Spryker\Zed\PerformanceAudit\Business\FactoryTrait\FactoryTrait;

class LoginHelper extends SharedLoginHelper
{
    use FactoryTrait;

    protected const LOGIN_URL = '/auth/login';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'auth__token';
    protected const LOGIN_FORM_NAME = 'auth';
}
