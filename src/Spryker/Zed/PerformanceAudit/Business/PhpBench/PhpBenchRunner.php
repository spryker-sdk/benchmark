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
    public function run(InputInterface $input, OutputInterface $output)
    {
        $message = 'Run PHPBench in PROJECT level';

        $output->writeln($message);

        $path = $this->config->getPathToProjectLevelTestDirectory();

        $resultCode = $this->runCommand($path, $input, $output);

        return $resultCode;
    }

    /**
     * @param string $path
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     *
     * @return int Exit code
     */
    protected function runCommand($path, InputInterface $input, OutputInterface $output)
    {
        $command = 'php vendor/bin/phpbench run %s';

        $command = sprintf($command, $path);

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
    protected function getProcess($command)
    {
        return new Process(explode(' ', $command), null, null, null, 0);
    }
}
