<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Command;

use Generated\Shared\Transfer\PhpBenchConfigurationTransfer;
use SprykerSdk\Zed\Benchmark\BenchmarkConfig;

class CommandBuilder implements CommandBuilderInterface
{
    protected const BASED_PHPBENCH_COMMAND = [
        'php',
        'vendor/bin/phpbench',
        'run',
    ];

    protected const CLI_BOOTSTRAP_CONFIG = '--bootstrap=%s';
    protected const CLI_ITERATIONS_CONFIG = '--iterations=%s';
    protected const CLI_REVOLUTIONS_CONFIG = '--revs=%s';
    protected const CLI_REPORT_CONFIG = '--report=%s';
    protected const CLI_TIME_UNIT_CONFIG = '--time-unit=%s';

    /**
     * @var \SprykerSdk\Zed\Benchmark\BenchmarkConfig
     */
    protected $benchmarkConfig;

    /**
     * @param \SprykerSdk\Zed\Benchmark\BenchmarkConfig $benchmarkConfig
     */
    public function __construct(BenchmarkConfig $benchmarkConfig)
    {
        $this->benchmarkConfig = $benchmarkConfig;
    }

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
     * @return string|false
     */
    protected function getFallbackBootstrapFolder()
    {
        $moduleRootFolder = dirname(__DIR__, 6);

        return realpath(sprintf('%s/%s', $moduleRootFolder, 'bootstrap'));
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getTestDirectory(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        return $phpBenchConfigurationTransfer->getTestDirectory() ?: $this->benchmarkConfig->getDefaultTestsDirectory();
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getBootstrapPath(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $bootstrapPath = $this->getPathToBootstrap($phpBenchConfigurationTransfer);

        return sprintf(static::CLI_BOOTSTRAP_CONFIG, $bootstrapPath);
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getIterations(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $iterations = $phpBenchConfigurationTransfer->getIterations() ?: $this->benchmarkConfig->getDefaultIterationCount();

        return sprintf(static::CLI_ITERATIONS_CONFIG, $iterations);
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getRevolutions(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $revolutions = $phpBenchConfigurationTransfer->getRevolutions() ?: $this->benchmarkConfig->getDefaultRevolutionCount();

        return sprintf(static::CLI_REVOLUTIONS_CONFIG, $revolutions);
    }

    /**
     * @param \Generated\Shared\Transfer\PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer
     *
     * @return string
     */
    protected function getReport(PhpBenchConfigurationTransfer $phpBenchConfigurationTransfer): string
    {
        $report = $phpBenchConfigurationTransfer->getReport() ?: $this->benchmarkConfig->getDefaultReportConfig();

        return sprintf(static::CLI_REPORT_CONFIG, $report);
    }

    /**
     * @return string
     */
    protected function getTimeUnit(): string
    {
        return sprintf(static::CLI_TIME_UNIT_CONFIG, $this->benchmarkConfig->getDefaultTimeUnit());
    }
}
