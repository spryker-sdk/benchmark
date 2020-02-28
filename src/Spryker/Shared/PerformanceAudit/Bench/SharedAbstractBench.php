<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Bench;

class SharedAbstractBench
{
    /**
     * @var string[]
     */
    protected $headers = [
        'Connection' => 'keep-alive',
        'Cache-Control' => 'max-age=0',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate',
    ];

    /**
     * @param string $key
     * @param string $value
     */
    protected function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * @return string[]
     */
    protected function getHeaders(): array
    {
        return $this->headers;
    }
}
