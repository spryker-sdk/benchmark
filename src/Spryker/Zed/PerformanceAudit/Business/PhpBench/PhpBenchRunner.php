<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench;

use Spryker\Zed\PerformanceAudit\PerformanceAuditConfig;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PhpBenchRunner implements PhpBenchRunnerInterface
{
    /**
     * @var \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig
     */
    protected $config;

    /**
     * @param \Spryker\Zed\PerformanceAudit\PerformanceAuditConfig $config
     */
    public function __construct(PerformanceAuditConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int Exit code
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $message = 'Run PHPBench in PROJECT level';

        $output->writeln($message);

        $resultCode = 0;

        foreach ($this->config::APPLICATIONS as $application) {
            $resultCode |= $this->runCommand($application, $input, $output);
        }

        return $resultCode;
    }

    /**
     * @param string $application
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     *
     * @return int|null
     */
    protected function runCommand(string $application, InputInterface $input, OutputInterface $output): ?int
    {
        $path = $this->config->getPathToProjectLevelTestDirectory($application);
        $bootstrap = $this->config->getPathToBootstrap($application);

        $command = 'php vendor/bin/phpbench run %s --bootstrap=%s --report=aggregate';
        $command = sprintf($command, $path, $bootstrap);

        if ($iterations = $input->getOption('iterations')) {
            $command .= ' --iterations=' . $iterations;
        }

        if ($revs = $input->getOption('revs')) {
            $command .= ' --revs=' . $revs;
        }

        $process = $this->getProcess($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        return $process->getExitCode();
    }

    /**
     * @param string $command
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function getProcess($command): Process
    {
        return new Process(explode(' ', $command), null, null, null, 0);
    }
}
