<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Command;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;

interface CommandBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return array
     */
    public function buildCommand(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): array;
}
