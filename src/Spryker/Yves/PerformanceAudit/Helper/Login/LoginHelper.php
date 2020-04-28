<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\PerformanceAudit\Helper\Login;

use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelper as SharedLoginHelper;
use Spryker\Yves\PerformanceAudit\FactoryTrait\FactoryTrait;

class LoginHelper extends SharedLoginHelper
{
    use FactoryTrait;

    protected const LOGIN_URL = '/login';
    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'loginForm__token';
    protected const LOGIN_FORM_NAME = 'loginForm';

    protected const COOKIE_DATA_INDEX = 1;
}
