<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PerformanceAudit\Business\PhpBench;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;
use Spryker\Zed\PerformanceAudit\Business\Exception\InvalidBootstrapException;
use Spryker\Zed\PerformanceAudit\PerformanceAuditConfig;
use Symfony\Component\Finder\Finder;
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
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return int
     */
    public function run(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): int
    {
        if ($phpBenchConfigurationTransfer->getTestDirectory()) {
            return $this->runCommand(
                $phpBenchConfigurationTransfer->getTestDirectory(),
                $phpBenchConfigurationTransfer->getIterations(),
                $phpBenchConfigurationTransfer->getRevolutions()
            );
        }

        $exitCode = 0;
        $testDirectories = $this->findTestDirectories();
        foreach ($testDirectories as $testDirectoryInformation) {
            $commandExitCode = $this->runCommand(
                $testDirectoryInformation->getPath(),
                $phpBenchConfigurationTransfer->getIterations(),
                $phpBenchConfigurationTransfer->getRevolutions()
            );
            if ($commandExitCode !== 0) {
                $exitCode = $commandExitCode;

                break;
            }
        }

        return $exitCode;
    }

    /**
     * @param string $path
     * @param int $iterations
     * @param int $revolutions
     *
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     *
     * @return int
     */
    protected function runCommand(string $path, int $iterations, int $revolutions): int
    {
        $bootstrapFilePath = $this->getPathToBootstrap($path);

        $command = 'php vendor/bin/phpbench run %s --bootstrap=%s --report=aggregate';
        $command = sprintf($command, $path, $bootstrapFilePath);

        if ($iterations) {
            $command .= ' --iterations=' . $iterations;
        }

        if ($revolutions) {
            $command .= ' --revs=' . $revolutions;
        }

        $process = $this->createProcess($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        return (int)$process->getExitCode();
    }

    /**
     * @param string $path
     *
     * @throws \Spryker\Zed\PerformanceAudit\Business\Exception\InvalidBootstrapException
     *
     * @return string
     */
    protected function getPathToBootstrap(string $path): string
    {
        $filePath = sprintf('%s/%s', $path, 'bootstrap.php');
        if (!file_exists($filePath)) {
            throw new InvalidBootstrapException(sprintf('Bootstrap file is missing in the `%s` folder', $path));
        }

        return $filePath;
    }

    /**
     * @param string $command
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function createProcess(string $command): Process
    {
        return new Process(explode(' ', $command), null, null, null, 0);
    }

    /**
     * @return \Symfony\Component\Finder\Finder
     */
    protected function findTestDirectories(): Finder
    {
        $finder = new Finder();

        $finder->directories()
            ->in($this->config->getTestsFolder())
            ->depth('== 0');

        return $finder;
    }
}
