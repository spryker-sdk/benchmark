<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\PhpBench;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;
use SprykerSdk\Zed\Benchmark\Business\Exception\InvalidBootstrapException;
use SprykerSdk\Zed\Benchmark\BenchmarkConfig;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PhpBenchRunner implements PhpBenchRunnerInterface
{
    protected const EXIT_CODE_SUCCESS = 0;

    /**
     * @var \SprykerSdk\Zed\Benchmark\BenchmarkConfig
     */
    protected $config;

    /**
     * @param \SprykerSdk\Zed\Benchmark\BenchmarkConfig $config
     */
    public function __construct(BenchmarkConfig $config)
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

        return $this->runTestsForAllDirectories($phpBenchConfigurationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return int
     */
    protected function runTestsForAllDirectories(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): int
    {
        $testDirectories = $this->findDirectoriesUnderPath($this->config->getTestsFolder());
        foreach ($testDirectories as $testDirectoryInformation) {
            $commandExitCode = $this->runCommand(
                $testDirectoryInformation->getRealPath(),
                $phpBenchConfigurationTransfer->getIterations(),
                $phpBenchConfigurationTransfer->getRevolutions()
            );

            if ($commandExitCode !== static::EXIT_CODE_SUCCESS) {
                return $commandExitCode;
            }
        }

        return static::EXIT_CODE_SUCCESS;
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
     * @throws \SprykerSdk\Zed\Benchmark\Business\Exception\InvalidBootstrapException
     *
     * @return string
     */
    protected function getPathToBootstrap(string $path): string
    {
        $filePath = sprintf('%s' . DIRECTORY_SEPARATOR . '%s', $path, 'bootstrap.php');
        if (file_exists($filePath)) {
            return $filePath;
        }
        $defaultBootstrapFile = $this->findDefaultBootstrapFile($path);

        if (!$defaultBootstrapFile) {
            throw new InvalidBootstrapException('Unable to find bootstrap file. Please add one or check if tests folder name contains tests layer name.');
        }

        return $defaultBootstrapFile;
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    protected function findDefaultBootstrapFile(string $path): ?string
    {
        $defaultBootstrapFolders = $this->findDirectoriesUnderPath($this->getFallbackBootstrapFolder());
        $pathParts = explode(DIRECTORY_SEPARATOR, $path);
        $pathParts = array_map('mb_strtoupper', $pathParts);
        foreach ($defaultBootstrapFolders as $defaultBootstrapFolder) {
            if (in_array(mb_strtoupper($defaultBootstrapFolder->getBasename()), $pathParts, true)) {
                return sprintf('%s' . DIRECTORY_SEPARATOR . '%s', $defaultBootstrapFolder->getRealPath(), 'bootstrap.php');
            }
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getFallbackBootstrapFolder(): string
    {
        $moduleRootFolder = __DIR__ . '/../../../../../..';

        return realpath(sprintf('%s/%s', $moduleRootFolder, 'bootstrap'));
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
     * @param string $path
     *
     * @return \Symfony\Component\Finder\Finder
     */
    protected function findDirectoriesUnderPath(string $path): Finder
    {
        $finder = new Finder();

        $finder->directories()
            ->in($path)
            ->depth('== 0');

        return $finder;
    }
}