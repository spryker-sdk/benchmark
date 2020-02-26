<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditBusinessFactory getFactory()
 */
class PerformanceAuditFacade extends AbstractFacade implements PerformanceAuditFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    public function runPhpBench(InputInterface $input, OutputInterface $output): ?int
    {
        return $this->getFactory()->createPhpBenchRunner()->run($input, $output);
    }
}
