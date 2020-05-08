<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\PerformanceAudit\Helper\Login;

use Generated\Shared\Transfer\LoginHeaderTransfer;
use Psr\Http\Message\ResponseInterface;
use Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface;
use Spryker\Glue\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface;
use Spryker\Shared\PerformanceAudit\Exception\LoginFailedException;
use Spryker\Shared\PerformanceAudit\Helper\Login\LoginHelperInterface;
use Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface;

class LoginHelper implements LoginHelperInterface
{
    protected const LOGIN_ENDPOINT = '/access-tokens';

    /**
     * @var \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface
     */
    protected $performanceAuditClient;

    /**
     * @var \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \Spryker\Glue\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \Spryker\Client\PerformanceAudit\PerformanceAuditClientInterface $performanceAuditClient
     * @param \Spryker\Shared\PerformanceAudit\Request\RequestBuilderInterface $requestBuilder
     * @param \Spryker\Glue\PerformanceAudit\Dependency\Service\PerformanceAuditToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        PerformanceAuditClientInterface $performanceAuditClient,
        RequestBuilderInterface $requestBuilder,
        PerformanceAuditToUtilEncodingServiceInterface $utilEncodingService
    ) {

        $this->performanceAuditClient = $performanceAuditClient;
        $this->requestBuilder = $requestBuilder;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return \Generated\Shared\Transfer\LoginHeaderTransfer
     */
    public function login(string $email, string $password): LoginHeaderTransfer
    {
        $request = $this->requestBuilder->buildRequest(
            RequestBuilderInterface::METHOD_POST,
            static::LOGIN_ENDPOINT,
            [],
            $this->buildLoginBody($email, $password)
        );

        $response = $this->performanceAuditClient->sendRequest($request);

        return $this->buildLoginHeaderTransferAuthorizationToken($response);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    protected function buildLoginBody(string $email, string $password): array
    {
        return [
            'data' => [
                'type' => 'access-tokens',
                'attributes' => [
                    'username' => $email,
                    'password' => $password,
                ],
            ],
        ];
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \Spryker\Shared\PerformanceAudit\Exception\LoginFailedException
     *
     * @return \Generated\Shared\Transfer\LoginHeaderTransfer
     */
    protected function buildLoginHeaderTransferAuthorizationToken(ResponseInterface $response): LoginHeaderTransfer
    {
        $responseData = $this->utilEncodingService->decodeJson($response->getBody()->getContents(), true);
        $attributes = $responseData['data']['attributes'] ?? null;

        if (!$attributes) {
            throw new LoginFailedException('Cookie with login data is missing in response. Please check provided credentials');
        }

        return (new LoginHeaderTransfer())
            ->setName('Authorization')
            ->setValue(sprintf('%s $%s', $attributes['tokenType'], $attributes['accessToken']));
    }
}
