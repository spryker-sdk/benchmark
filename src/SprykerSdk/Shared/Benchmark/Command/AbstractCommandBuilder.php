<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Command;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;

abstract class AbstractCommandBuilder implements CommandBuilderInterface
{
    protected const BASED_PHPBENCH_COMMAND = [
        'php',
        'vendor/bin/phpbench',
        'run',
    ];

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string[]
     */
    public function buildCommand(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): array
    {
        $commandTemplate = self::BASED_PHPBENCH_COMMAND;

        $commandTemplate[] = $this->getTestDirectory($phpBenchConfigurationTransfer);
        $commandTemplate[] = $this->getBootstrapPath($phpBenchConfigurationTransfer);
        $commandTemplate[] = $this->getIterations($phpBenchConfigurationTransfer);
        $commandTemplate[] = $this->getRevolutions($phpBenchConfigurationTransfer);
        $commandTemplate[] = $this->getReport($phpBenchConfigurationTransfer);
        $commandTemplate[] = $this->getTimeUnit();

        return $commandTemplate;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getPathToBootstrap(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $path = $this->getTestDirectory($phpBenchConfigurationTransfer);

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
        return sprintf('%s/%s', $this->getFallbackBootstrapFolder(), 'bootstrap.php');
    }

    /**
     * @return string
     */
    protected function getFallbackBootstrapFolder(): string
    {
        $moduleRootFolder = __DIR__ . '/../../../../../..';

        return realpath(sprintf('%s/%s/%s', $moduleRootFolder, 'bootstrap', $this->getApplication()));
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getTestDirectory(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        return $phpBenchConfigurationTransfer->getTestDirectory() ?: $this->getDefaultTestsDirectory();
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getBootstrapPath(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $bootstrapPath = $this->getPathToBootstrap($phpBenchConfigurationTransfer);

        return '--bootstrap=' . $bootstrapPath;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getIterations(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $iterations = $phpBenchConfigurationTransfer->getIterations() ?: $this->getIterationConfig();

        return '--iterations=' . $iterations;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getRevolutions(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $revolutions = $phpBenchConfigurationTransfer->getRevolutions() ?: $this->getRevolutionConfig();

        return '--revs=' . $revolutions;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getReport(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer)
    {
        $report = $phpBenchConfigurationTransfer->getReport() ?: $this->getReportConfig();

        return '--report=' . $report;
    }

    /**
     * @return string
     */
    protected function getTimeUnit(): string
    {
        return '--time-unit=milliseconds';
    }

    /**
     * @return string
     */
    abstract protected function getApplication(): string;

    /**
     * @return string
     */
    abstract protected function getDefaultTestsDirectory(): string;

    /**
     * @return int
     */
    abstract protected function getIterationConfig(): int;

    /**
     * @return int
     */
    abstract protected function getRevolutionConfig(): int;

    /**
     * @return string
     */
    abstract protected function getReportConfig(): string;
}