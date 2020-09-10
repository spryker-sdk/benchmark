<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Communication\Console;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \SprykerSdk\Zed\Benchmark\Business\BenchmarkFacadeInterface getFacade()
 * @method \SprykerSdk\Zed\Benchmark\Communication\BenchmarkCommunicationFactory getFactory()
 */
class BenchmarkRunConsole extends Console
{
    public const COMMAND_NAME = 'benchmark:run';
    public const COMMAND_DESCRIPTION = 'Will run test Zed tests using phpbench framework';

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $benchmarkConfig = $this->getFactory()->getConfig();

        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addOption(
                'iterations',
                null,
                InputOption::VALUE_OPTIONAL,
                'Iterations represent the number of times we will perform the benchmark',
                $benchmarkConfig->getIterations()
            )->addOption(
                'revs',
                null,
                InputOption::VALUE_OPTIONAL,
                'The number of times the benchmark is executed consecutively within a single time measurement',
                $benchmarkConfig->getRevolutions()
            )->addOption(
                'path',
                null,
                InputOption::VALUE_OPTIONAL,
                'Path to the directory that contains tests to be executed',
                $benchmarkConfig->getTestsDirectory()
            )->addOption(
                'report',
                null,
                InputOption::VALUE_OPTIONAL,
                'Configuration for customisation benchmark report',
                $benchmarkConfig->getReport()
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Run PHPBench on project level');

        return $this->getFacade()->runPhpBench($this->createPhpBenchConfigurationTransfer($input));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return \Generated\Shared\Transfer\PhpBenchConfigurationTransfer
     */
    protected function createPhpBenchConfigurationTransfer(InputInterface $input): PhpBenchConfigurationTransfer
    {
        $phpBenchConfigurationTransfer = (new PhpBenchConfigurationTransfer())
            ->setTestDirectory($input->getOption('path'))
            ->setIterations((int)$input->getOption('iterations'))
            ->setReport($input->getOption('report'))
            ->setRevolutions((int)$input->getOption('revs'));

        return $phpBenchConfigurationTransfer;
    }
}
