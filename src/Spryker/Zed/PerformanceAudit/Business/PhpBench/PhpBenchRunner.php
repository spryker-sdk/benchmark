<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench;

use Spryker\Zed\PerformanceAudit\Business\Exception\InvalidConfigurationException;
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
     * @param string $path
     * @param int|null $iterations
     * @param int|null $revs
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     * @throws \Spryker\Zed\PerformanceAudit\Business\Exception\InvalidConfigurationException
     *
     * @return int
     */
    protected function runCommand(string $path, ?int $iterations = null, ?int $revs = null): int
    {
        $bootstrapFilePath = $this->getPathToBootstrap($path);

        if (!file_exists($bootstrapFilePath)) {
            throw new InvalidConfigurationException(sprintf('Could not find bootstrap file at `%s`. Please add file or adjust configs.', $bootstrapFilePath));
        }

        $command = 'php vendor/bin/phpbench run %s --bootstrap=%s --report=aggregate';
        $command = sprintf($command, $path, $bootstrapFilePath);

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

        return (int)$process->getExitCode();
    }

    /**
     * @param string $application
     *
     * @return string
     */
    public function getPathToProjectLevelTestDirectory(string $application): string
    {
        return $this->config->getTestsFolder() . ucfirst($application);
    }

    /**
     * @param string $path
     *
     * @throws \Spryker\Zed\PerformanceAudit\Business\Exception\InvalidConfigurationException
     *
     * @return string
     */
    protected function getPathToBootstrap(string $path): string
    {
        $applications = $this->config->getApplicationsList();

        foreach ($applications as $application) {
            $application = ucfirst($application);
            if (strpos($path, $application) === false) {
                continue;
            }

            $methodName = sprintf('get%sBootstrapFilePath', $application);
            if (!method_exists($this->config, $methodName)) {
                throw new InvalidConfigurationException(sprintf('Missing bootstrap file configuration for `%s` layer.', $application));
            }

            return $this->config->{$methodName}();
        }
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
