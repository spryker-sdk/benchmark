<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Helper\Login;

use Generated\Shared\Transfer\LoginHeaderTransfer;

interface LoginHelperInterface
{
    /**
     * @param string $email
     * @param string $password
     *
     * @return \Generated\Shared\Transfer\LoginHeaderTransfer
     */
    public function login(string $email, string $password): LoginHeaderTransfer;
}
