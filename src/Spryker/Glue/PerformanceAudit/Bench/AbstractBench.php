<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Bench;

use Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver;
use Spryker\Glue\PerformanceAudit\PerformanceAuditFactory;
use Spryker\Shared\PerformanceAudit\Bench\AbstractSharedBench;
use Spryker\Shared\PerformanceAudit\Request\RequestInterface;

class AbstractBench extends AbstractSharedBench
{
    protected const LOGIN_EMAIL = 'spencor.hopkin@spryker.com';
    protected const LOGIN_PASSWORD = 'change123';
    protected const LOGIN_ENDPOINT = '/access-tokens';

    /**
     * @var \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    protected $factory;

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
     * @return void
     */
    protected function login(): void
    {
        if ($this->hasHeader('Authorization')) {
            return;
        }

        $loginRequestData = [
            'data' => [
                'type' => 'access-tokens',
                'attributes' => [
                    'username' => static::LOGIN_EMAIL,
                    'password' => static::LOGIN_PASSWORD,
                ],
            ],
        ];

        $response = $this->sendRequest(RequestInterface::METHOD_POST, static::LOGIN_ENDPOINT, $loginRequestData);

        $responseData = json_decode($response->getBody()->getContents(), true);
        $token = $responseData['data']['attributes']['tokenType'] . ' ' . $responseData['data']['attributes']['accessToken'];

        $this->addHeader('Authorization', $token);
    }

    /**
     * @return \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    protected function getRequest(): RequestInterface
    {
        return $this->getFactory()->createRequest();
    }

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    protected function getFactory(): PerformanceAuditFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @return \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory
     */
    private function resolveFactory()
    {
        /** @var \Spryker\Glue\PerformanceAudit\PerformanceAuditFactory $factory */
        $factory = $this->getFactoryResolver()->resolve(self::class);

        return $factory;
    }

    /**
     * @return \Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver(): FactoryResolver
    {
        return new FactoryResolver();
    }
}
