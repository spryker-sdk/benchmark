<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\PerformanceAudit\Request;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\PerformanceAudit\Exception\UnexpectedStatusCodeException;

abstract class AbstractSharedRequest implements RequestInterface
{
    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\UnexpectedStatusCodeException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(string $method, string $url, array $options, int $expectedStatusCode = 200): ResponseInterface
    {
        $response = $this->getClient()->request($method, $this->getRequestBaseUrl() . $url, $options);

        if ($response->getStatusCode() !== $expectedStatusCode) {
            $message = sprintf('Unexpected status code \'%s\', \'%s\' was expected', $response->getStatusCode(), $expectedStatusCode);

            throw new UnexpectedStatusCodeException($message);
        }

        return $response;
    }

    /**
     * @return string
     */
    abstract protected function getRequestBaseUrl(): string;

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    abstract protected function getClient(): ClientInterface;
}
