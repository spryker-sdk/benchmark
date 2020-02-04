<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench\Extension;

use PhpBench\Benchmark\Remote\Launcher;
use PhpBench\Executor\Benchmark\TemplateExecutor;

/**
 * Class TtfbExecutor
 *
 * @package Spryker\Zed\PerformanceAudit\Business\PhpBench\Extension
 */
class TtfbExecutor extends TemplateExecutor
{
    /**
     * @param \PhpBench\Benchmark\Remote\Launcher $launcher
     */
    public function __construct(Launcher $launcher)
    {
        parent::__construct($launcher, __DIR__ . '/template/ttfb.template');
    }
}
