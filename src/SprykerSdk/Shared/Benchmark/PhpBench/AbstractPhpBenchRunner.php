<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\PhpBench;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;
use SprykerSdk\Shared\Benchmark\PhpBench\PhpBenchRunnerInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

abstract class AbstractPhpBenchRunner implements PhpBenchRunnerInterface
{
    protected const EXIT_CODE_SUCCESS = 0;

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return int
     */
    public function run(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): int
    {
        $testDirectory = $phpBenchConfigurationTransfer->getTestDirectory() ?: $this->getDefaultTestsFolder();
        return $this->runCommand(
            $testDirectory,
            $phpBenchConfigurationTransfer->getIterations(),
            $phpBenchConfigurationTransfer->getRevolutions()
        );
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
     * @return string
     */
    protected function getPathToBootstrap(string $path): string
    {
        $filePath = sprintf('%s' . DIRECTORY_SEPARATOR . '%s', $path, 'bootstrap.php');
        if (file_exists($filePath)) {
            return $filePath;
        }

        return $this->getDefaultBootstrapFile();
    }

    /**
     * @return string
     */
    protected function getDefaultBootstrapFile(): string
    {
        return sprintf('%s/%s', $this->getFallbackBootstrapFolder() , 'bootstrap.php');
    }

    /**
     * @return string
     */
    protected function getFallbackBootstrapFolder(): string
    {
        $moduleRootFolder = __DIR__ . '/../../../../../..';

        return realpath(sprintf('%s/%s/%s', $moduleRootFolder, 'bootstrap', $this->getLayer()));
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
     * @return string
     */
    abstract protected function getLayer(): string;

    /**
     * @return string
     */
    abstract protected function getDefaultTestsFolder(): string;
}
