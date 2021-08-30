<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business;

use GuzzleHttp\Cookie\CookieJarInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;
use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface;
use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\FormCsrfTokenHelper;
use SprykerSdk\Shared\Benchmark\Helper\GuiTable\GuiTableHelper;
use SprykerSdk\Shared\Benchmark\Helper\GuiTable\GuiTableHelperInterface;
use SprykerSdk\Shared\Benchmark\Helper\Html\DomHelper;
use SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface;
use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelper;
use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;
use SprykerSdk\Zed\Benchmark\BenchmarkDependencyProvider;
use SprykerSdk\Zed\Benchmark\Business\Command\CommandBuilder;
use SprykerSdk\Zed\Benchmark\Business\Command\CommandBuilderInterface;
use SprykerSdk\Zed\Benchmark\Business\Helper\Login\LoginHelper;
use SprykerSdk\Zed\Benchmark\Business\Helper\Login\LoginHelperInterface;
use SprykerSdk\Zed\Benchmark\Business\Helper\Login\MerchantPortalLoginHelper;
use SprykerSdk\Zed\Benchmark\Business\PhpBench\PhpBenchRunner;
use SprykerSdk\Zed\Benchmark\Business\PhpBench\PhpBenchRunnerInterface;
use SprykerSdk\Zed\Benchmark\Business\Request\RequestBuilder;
use SprykerSdk\Zed\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;

/**
 * @method \SprykerSdk\Zed\Benchmark\BenchmarkConfig getConfig()
 */
class BenchmarkBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\PhpBench\PhpBenchRunnerInterface
     */
    public function createPhpBenchRunner(): PhpBenchRunnerInterface
    {
        return new PhpBenchRunner($this->createCommandBuilder());
    }

    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\Command\CommandBuilderInterface
     */
    public function createCommandBuilder(): CommandBuilderInterface
    {
        return new CommandBuilder($this->getConfig());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder($this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \SprykerSdk\Zed\Benchmark\Business\Helper\Login\LoginHelperInterface
     */
    public function createLoginHelper(): LoginHelperInterface
    {
        return new LoginHelper(
            $this->getBenchmarkClient(),
            $this->createRequestBuilder(),
            $this->getCookieJar(),
            $this->createCsrfTokenHelper(),
        );
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface
     */
    public function createMerchantPortalLoginHelper(): LoginHelperInterface
    {
        return new MerchantPortalLoginHelper(
            $this->getBenchmarkClient(),
            $this->createRequestBuilder(),
            $this->getCookieJar(),
            $this->createCsrfTokenHelper(),
        );
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface
     */
    public function createHttpHelper(): HttpHelperInterface
    {
        return new HttpHelper($this->getBenchmarkClient());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    public function createCsrfTokenHelper(): CsrfTokenHelperInterface
    {
        return new FormCsrfTokenHelper(
            $this->createRequestBuilder(),
            $this->getBenchmarkClient(),
            $this->getCookieJar(),
            $this->createDomHelper()
        );
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface
     */
    public function createDomHelper(): DomHelperInterface
    {
        return new DomHelper();
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\GuiTable\GuiTableHelperInterface
     */
    public function createGuiTableHelper(): GuiTableHelperInterface
    {
        return new GuiTableHelper($this->createDomHelper());
    }

    /**
     * @return \SprykerSdk\Client\Benchmark\BenchmarkClientInterface
     */
    public function getBenchmarkClient(): BenchmarkClientInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::CLIENT_BENCHMARK);
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    public function getCookieJar(): CookieJarInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::COOKIE_JAR);
    }

    /**
     * @return \SprykerSdk\Zed\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): BenchmarkToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
