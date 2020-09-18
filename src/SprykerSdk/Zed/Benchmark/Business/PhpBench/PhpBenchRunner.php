<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\PhpBench;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;
use SprykerSdk\Zed\Benchmark\Business\Command\CommandBuilderInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PhpBenchRunner implements PhpBenchRunnerInterface
{
    protected const EXIT_CODE_SUCCESS = 0;

    /**
     * @var \SprykerSdk\Zed\Benchmark\Business\Command\CommandBuilderInterface
     */
    protected $commandBuilder;

    /**
     * @param \SprykerSdk\Zed\Benchmark\Business\Command\CommandBuilderInterface $commandBuilder
     */
    public function __construct(CommandBuilderInterface $commandBuilder)
    {
        $this->commandBuilder = $commandBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     *
     * @return int
     */
    public function run(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): int
    {
        $process = $this->createProcess(
            $this->commandBuilder->buildCommand($phpBenchConfigurationTransfer)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        return (int)$process->getExitCode();
    }

    /**
     * @param array $command
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function createProcess(array $command): Process
    {
        return new Process($command, null, null, null, 0);
    }
}
