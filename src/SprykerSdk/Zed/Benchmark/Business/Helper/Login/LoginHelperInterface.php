<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\Login;

interface LoginHelperInterface
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     */
    public function login(string $username, string $password): void;
}
