<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark;

use GuzzleHttp\Cookie\CookieJarInterface;
use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface;
use SprykerSdk\Shared\Benchmark\Helper\CsrfToken\FormCsrfTokenHelper;
use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelper;
use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface;
use SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use SprykerSdk\Yves\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;
use SprykerSdk\Yves\Benchmark\Helper\Login\LoginHelper;
use SprykerSdk\Yves\Benchmark\Request\RequestBuilder;

/**
 * @method \SprykerSdk\Yves\Benchmark\BenchmarkConfig getConfig()
 * @method \SprykerSdk\Client\Benchmark\BenchmarkClientInterface getClient()
 */
class BenchmarkFactory extends AbstractFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface
     */
    public function createLoginHelper(): LoginHelperInterface
    {
        return new LoginHelper($this->getClient(), $this->createRequestBuilder(), $this->getCookieJar(), $this->createCsrfTokenHelper());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder($this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\CsrfToken\CsrfTokenHelperInterface
     */
    public function createCsrfTokenHelper(): CsrfTokenHelperInterface
    {
        return new FormCsrfTokenHelper($this->createRequestBuilder(), $this->getClient());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface
     */
    public function createHttpHelper(): HttpHelperInterface
    {
        return new HttpHelper($this->getClient());
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJarInterface
     */
    public function getCookieJar(): CookieJarInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::COOKIE_JAR);
    }

    /**
     * @return \SprykerSdk\Yves\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): BenchmarkToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
