<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Request;

use Spryker\Glue\PerformanceAudit\FactoryTrait\FactoryTrait;
use Spryker\Shared\PerformanceAudit\Request\Request;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;

class RequestBuilder implements RequestBuilderInterface
{
    use FactoryTrait;

    /**
     * @var string[]
     */
    protected $headers = [
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate',
        'Accept' => 'application/vnd.api+json',
        'Content-Type' => 'application/json',
    ];

    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    public function buildRequest(): RequestInterface
    {
        $factory = $this->getFactory();

        return new Request($factory->getGuzzleClient(), $factory->getConfig()->getRequestBaseUrl(), $this->headers);
    }
}
