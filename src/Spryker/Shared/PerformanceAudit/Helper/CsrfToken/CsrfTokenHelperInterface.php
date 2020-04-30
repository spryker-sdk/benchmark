<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Helper\CsrfToken;

use Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer;

interface CsrfTokenHelperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PhpBenchCsrfTokenConfigTransfer $csrfTokenConfigTransfer
     *
     * @return string
     */
    public function getToken(PhpBenchCsrfTokenConfigTransfer $csrfTokenConfigTransfer): string;
}
