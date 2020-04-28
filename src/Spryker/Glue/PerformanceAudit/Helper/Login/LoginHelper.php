<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Helper\Login;

use Spryker\Glue\PerformanceAudit\FactoryTrait\FactoryTrait;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;

class LoginHelper implements LoginHelperInterface
{
    use FactoryTrait;

    protected const LOGIN_ENDPOINT = '/access-tokens';

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestInterface
     */
    protected $request;

    /**
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface $requestBuilder
     */
    public function __construct(RequestBuilderInterface $requestBuilder)
    {
        $this->request = $requestBuilder->buildRequest();
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return void
     */
    public function login(string $email, string $password): void
    {
        if ($this->request->hasHeader('Authorization')) {
            return;
        }

        $loginRequestData = [
            'data' => [
                'type' => 'access-tokens',
                'attributes' => [
                    'username' => $email,
                    'password' => $password,
                ],
            ],
        ];

        $response = $this->request->sendPostRequest(static::LOGIN_ENDPOINT, $loginRequestData);

        $responseData = json_decode($response->getBody()->getContents(), true);

        $this->request->addHeader('Authorization', $this->buildAuthorizationToken($responseData));
    }

    /**
     * @param array $responseData
     *
     * @return string
     */
    protected function buildAuthorizationToken(array $responseData): string
    {
        $attributes = $responseData['data']['attributes'];

        return sprintf('%s $%s', $attributes['tokenType'], $attributes['accessToken']);
    }
}
