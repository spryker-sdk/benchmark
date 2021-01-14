<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Login;


class MerchantPortalLoginHelper extends LoginHelper
{
    protected const LOGIN_FORM_URL = '/security-merchant-portal-gui/login';
    protected const LOGIN_POST_URL = '/security-merchant-portal-gui/login_check';

    protected const LOGIN_CSRF_FORM_ELEMENT_ID = 'security-merchant-portal-gui__token';
    protected const LOGIN_FORM_NAME = 'security-merchant-portal-gui';
}
