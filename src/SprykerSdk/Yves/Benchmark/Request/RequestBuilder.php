<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Yves\Benchmark\Request;

use SprykerSdk\Shared\Benchmark\Request\AbstractRequestBuilder;
use SprykerSdk\Yves\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;
use SprykerSdk\Yves\Benchmark\BenchmarkConfig;

class RequestBuilder extends AbstractRequestBuilder
{
    /**
     * @var \SprykerSdk\Yves\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerSdk\Yves\Benchmark\BenchmarkConfig
     */
    protected $performanceAuditConfig;

    /**
     * @param \SprykerSdk\Yves\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerSdk\Yves\Benchmark\BenchmarkConfig $performanceAuditConfig
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
