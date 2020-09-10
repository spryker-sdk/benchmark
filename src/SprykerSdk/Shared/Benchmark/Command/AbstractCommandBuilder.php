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

    protected const BENCHMARK_CLI_BOOTSTRAP_CONFIG = '--bootstrap=';

    protected const BENCHMARK_CLI_ITERATIONS_CONFIG = '--iterations=';

    protected const BENCHMARK_CLI_REVOLUTIONS_CONFIG = '--revs=';

    protected const BENCHMARK_CLI_REPORT_CONFIG = '--report=';

    protected const BENCHMARK_CLI_TIME_UNIT_CONFIG = '--time-unit=';

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string[]
     */
    public function buildCommand(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): array
    {
        $commandTemplate = static::BASED_PHPBENCH_COMMAND;

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
        $moduleRootFolder = dirname(__DIR__, 6);

        return realpath(sprintf('%s/%s/%s', $moduleRootFolder, 'bootstrap', $this->getApplication()));
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getTestDirectory(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        return $phpBenchConfigurationTransfer->getTestDirectory() ?: $this->getApplicationTestsDirectory();
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getBootstrapPath(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $bootstrapPath = $this->getPathToBootstrap($phpBenchConfigurationTransfer);

        return static::BENCHMARK_CLI_BOOTSTRAP_CONFIG . $bootstrapPath;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getIterations(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $iterations = $phpBenchConfigurationTransfer->getIterations();

        return static::BENCHMARK_CLI_ITERATIONS_CONFIG . $iterations;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getRevolutions(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $revolutions = $phpBenchConfigurationTransfer->getRevolutions();

        return static::BENCHMARK_CLI_REVOLUTIONS_CONFIG . $revolutions;
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getReport(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer)
    {
        $report = $phpBenchConfigurationTransfer->getReport();

        return static::BENCHMARK_CLI_REPORT_CONFIG . $report;
    }

    /**
     * @return string
     */
    protected function getTimeUnit(): string
    {
        return static::BENCHMARK_CLI_TIME_UNIT_CONFIG . 'milliseconds';
    }

    /**
     * @return string
     */
    abstract protected function getApplication(): string;

    /**
     * @return string
     */
    abstract protected function getApplicationTestsDirectory(): string;
}
