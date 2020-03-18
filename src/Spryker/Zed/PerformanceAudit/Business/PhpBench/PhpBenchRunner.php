<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench;

use InvalidArgumentException;
use Spryker\Zed\PerformanceAudit\PerformanceAuditConfig;
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
     * @param string|null $testDirectoryPath
     * @param int|null $iterations
     * @param int|null $revs
     *
     * @return int Exit code
     */
    public function run(?string $testDirectoryPath = null, ?int $iterations = null, ?int $revs = null): int
    {
        $resultCode = 0;
        $applicationsList = $this->config->getApplicationsList();

        if (!$testDirectoryPath) {
            foreach ($applicationsList as $application) {
                $resultCode |= $this->runCommand($this->getPathToProjectLevelTestDirectory($application), $iterations, $revs);
            }

            return $resultCode;
        }

        return $this->runCommand($testDirectoryPath, $iterations, $revs);
    }

    /**
     * @param string|null $path
     * @param int|null $iterations
     * @param int|null $revs
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     * @throws \InvalidArgumentException
     *
     * @return int|null
     */
    protected function runCommand(?string $path, ?int $iterations = null, ?int $revs = null): ?int
    {
        $bootstrap = $this->getPathToBootstrap($path);

        if (!file_exists($bootstrap)) {
            throw new InvalidArgumentException('Could not find bootstrap file. Bootstrap file must be defined!');
        }

        $command = 'php vendor/bin/phpbench run %s --bootstrap=%s --report=aggregate';
        $command = sprintf($command, $path, $bootstrap);

        if ($iterations) {
            $command .= ' --iterations=' . $iterations;
        }

        if ($revs) {
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
     * @param string $application
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getPathToProjectLevelTestDirectory(string $application): string
    {
        switch ($application) {
            case PerformanceAuditConfig::APPLICATION_YVES:
                return $this->config->getPathToYvesTests();
            case PerformanceAuditConfig::APPLICATION_ZED:
                return $this->config->getPathToZedTests();
            case PerformanceAuditConfig::APPLICATION_GLUE:
                return $this->config->getPathToGlueTests();
        }

        throw new InvalidArgumentException();
    }

    /**
     * @param string $path
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    protected function getPathToBootstrap(string $path): string
    {
        $applications = $this->config->getApplicationsList();

        foreach ($applications as $application) {
            if (strpos($path, ucfirst($application))) {
                switch ($application) {
                    case PerformanceAuditConfig::APPLICATION_YVES:
                        return $this->config->getYvesBootstrapFilePath();
                    case PerformanceAuditConfig::APPLICATION_ZED:
                        return $this->config->getZedBootstrapFilePath();
                    case PerformanceAuditConfig::APPLICATION_GLUE:
                        return $this->config->getGlueBootstrapFilePath();
                }
            }
        }

        throw new InvalidArgumentException();
    }

    /**
     * @param string $command
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function getProcess(string $command): Process
    {
        return new Process(explode(' ', $command), null, null, null, 0);
    }
}
