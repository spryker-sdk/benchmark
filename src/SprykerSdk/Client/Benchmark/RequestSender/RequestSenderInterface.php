<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Client\Benchmark\RequestSender;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface RequestSenderInterface
{
    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @param int $expectedStatusCode
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [], int $expectedStatusCode = 200): ResponseInterface;
}
