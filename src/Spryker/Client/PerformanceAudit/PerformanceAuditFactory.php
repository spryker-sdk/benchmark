<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\PerformanceAudit;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface;
use Spryker\Client\PerformanceAudit\RequestSender\RequestSender;
use Spryker\Client\PerformanceAudit\RequestSender\RequestSenderInterface;

class PerformanceAuditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\PerformanceAudit\RequestSender\RequestSenderInterface
     */
    public function createRequestSender(): RequestSenderInterface
    {
        return new RequestSender($this->getGuzzleClient());
    }

    /**
     * @return \Spryker\Client\PerformanceAudit\Dependency\Guzzle\PerformanceAuditToGuzzleClientInterface
     */
    public function getGuzzleClient(): PerformanceAuditToGuzzleClientInterface
    {
        return $this->getProvidedDependency(PerformanceAuditDependencyProvider::CLIENT_GUZZLE);
    }
}
