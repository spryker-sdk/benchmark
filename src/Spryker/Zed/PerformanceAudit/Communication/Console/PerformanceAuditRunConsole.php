<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\PerformanceAudit\Business\PerformanceAuditFacadeInterface getFacade()
 */
class PerformanceAuditRunConsole extends Console
{
    public const COMMAND_NAME = 'performance-audit:run';
    public const COMMAND_DESCRIPTION = 'Will run test using phpbench framework';

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addOption('iterations', null, InputOption::VALUE_OPTIONAL, 'Iterations represent the number of times we will perform the benchmark')
            ->addOption('revs', null, InputOption::VALUE_OPTIONAL, 'The number of times the benchmark is executed consecutively within a single time measurement')
            ->addOption('path', null, InputOption::VALUE_OPTIONAL, 'Path to the directory that contains tests to be executed');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Run PHPBench on project level');

        return $this->getFacade()->runPhpBench(
            $input->getOption('path'),
            (int)$input->getOption('iterations'),
            (int)$input->getOption('revs')
        );
    }
}
