<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Client\Benchmark;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerSdk\Client\Benchmark\Dependency\Guzzle\BenchmarkToGuzzleClientInterface;
use SprykerSdk\Client\Benchmark\RequestSender\RequestSender;
use SprykerSdk\Client\Benchmark\RequestSender\RequestSenderInterface;

class BenchmarkFactory extends AbstractFactory
{
    /**
     * @return \SprykerSdk\Client\Benchmark\RequestSender\RequestSenderInterface
     */
    public function createRequestSender(): RequestSenderInterface
    {
        return new RequestSender($this->getGuzzleClient());
    }

    /**
     * @return \SprykerSdk\Client\Benchmark\Dependency\Guzzle\BenchmarkToGuzzleClientInterface
     */
    public function getGuzzleClient(): BenchmarkToGuzzleClientInterface
    {
        return $this->getProvidedDependency(BenchmarkDependencyProvider::CLIENT_GUZZLE);
    }
}
