<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark;

use Spryker\Glue\Kernel\AbstractFactory;
use SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;
use SprykerSdk\Glue\Benchmark\Helper\Login\LoginHelper;
use SprykerSdk\Glue\Benchmark\Request\RequestBuilder;
use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelper;
use SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface;
use SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

/**
 * @method \SprykerSdk\Glue\Benchmark\BenchmarkConfig getConfig()
 * @method \SprykerSdk\Client\Benchmark\BenchmarkClientInterface getClient()
 */
class BenchmarkFactory extends AbstractFactory
{
    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface
     */
    public function createLoginHelper(): LoginHelperInterface
    {
        return new LoginHelper($this->getClient(), $this->createRequestBuilder(), $this->getUtilEncodingService());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder($this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \SprykerSdk\Shared\Benchmark\Helper\Http\HttpHelperInterface
     */
    public function createHttpHelper(): HttpHelperInterface
    {
        return new HttpHelper($this->getClient());
    }

    /**
     * @return \SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): BenchmarkToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::SERVICE_UTIL_ENCODING);
    }
}
