<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\Request;

use SprykerSdk\Glue\Benchmark\BenchmarkConfig;
use SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;
use SprykerSdk\Shared\Benchmark\Request\AbstractRequestBuilder;

class RequestBuilder extends AbstractRequestBuilder
{
    /**
     * @var array<string>
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
     * @var \SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerSdk\Glue\Benchmark\BenchmarkConfig
     */
    protected $performanceAuditConfig;

    /**
     * @param \SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerSdk\Glue\Benchmark\BenchmarkConfig $performanceAuditConfig
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
