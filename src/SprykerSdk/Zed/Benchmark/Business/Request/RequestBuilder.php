<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Request;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use SprykerSdk\Shared\Benchmark\Request\AbstractRequestBuilder;
use SprykerSdk\Zed\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;
use SprykerSdk\Zed\Benchmark\BenchmarkConfig;

class RequestBuilder extends AbstractRequestBuilder
{
    /**
     * @var \SprykerSdk\Zed\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerSdk\Zed\Benchmark\BenchmarkConfig
     */
    protected $performanceAuditConfig;

    /**
     * @param \SprykerSdk\Zed\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerSdk\Zed\Benchmark\BenchmarkConfig $performanceAuditConfig
     */
    public function __construct(
        BenchmarkToUtilEncodingServiceInterface $utilEncodingService,
        BenchmarkConfig $performanceAuditConfig
    ) {
        $this->utilEncodingService = $utilEncodingService;
        $this->performanceAuditConfig = $performanceAuditConfig;
    }

    /**
     * @return string
     */
    protected function getRequestBaseUrl(): string
    {
        return $this->performanceAuditConfig->getRequestBaseUrl();
    }

    /**
     * @param array $body
     *
     * @return string
     */
    protected function formatBodyToString(array $body): string
    {
        return $this->utilEncodingService->encodeJson($body);
    }
}
