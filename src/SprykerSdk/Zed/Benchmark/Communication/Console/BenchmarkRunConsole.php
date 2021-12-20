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
 */
class BenchmarkRunConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'benchmark:run';

    /**
     * @var string
     */
    public const COMMAND_DESCRIPTION = 'Will run test Zed tests using phpbench framework';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addOption(
                'iterations',
                null,
                InputOption::VALUE_OPTIONAL,
                'Iterations represent the number of times we will perform the benchmark',
            )->addOption(
                'revs',
                null,
                InputOption::VALUE_OPTIONAL,
                'The number of times the benchmark is executed consecutively within a single time measurement',
            )->addOption(
                'path',
                null,
                InputOption::VALUE_OPTIONAL,
                'Path to the directory that contains tests to be executed',
            )->addOption(
                'report',
                null,
                InputOption::VALUE_OPTIONAL,
                'Configuration for customisation benchmark report',
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
        return (new PhpBenchConfigurationTransfer())
            ->setTestDirectory($this->getTestDirectoryOption($input))
            ->setIterations($this->getIterationsOption($input))
            ->setReport($this->getReportOption($input))
            ->setRevolutions($this->getRevolutionsOption($input));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getTestDirectoryOption(InputInterface $input): string
    {
        /** @var string $path */
        $path = $input->getOption('path');

        return (string)$path;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return int
     */
    protected function getIterationsOption(InputInterface $input): int
    {
        /** @var int $iterations */
        $iterations = $input->getOption('iterations');

        return (int)$iterations;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getReportOption(InputInterface $input): string
    {
        /** @var string $report */
        $report = $input->getOption('report');

        return (string)$report;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return int
     */
    protected function getRevolutionsOption(InputInterface $input): int
    {
        /** @var int $revs */
        $revs = $input->getOption('revs');

        return (int)$revs;
    }
}
