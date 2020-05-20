<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Glue\Benchmark\Helper\Login;

use Generated\Shared\Transfer\LoginHeaderTransfer;
use Psr\Http\Message\ResponseInterface;
use SprykerSdk\Client\Benchmark\BenchmarkClientInterface;
use SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface;
use SprykerSdk\Shared\Benchmark\Exception\LoginFailedException;
use SprykerSdk\Shared\Benchmark\Helper\Login\LoginHelperInterface;
use SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface;

class LoginHelper implements LoginHelperInterface
{
    protected const LOGIN_ENDPOINT = '/access-tokens';

    /**
     * @var \SprykerSdk\Client\Benchmark\BenchmarkClientInterface
     */
    protected $performanceAuditClient;

    /**
     * @var \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerSdk\Client\Benchmark\BenchmarkClientInterface $performanceAuditClient
     * @param \SprykerSdk\Shared\Benchmark\Request\RequestBuilderInterface $requestBuilder
     * @param \SprykerSdk\Glue\Benchmark\Dependency\Service\BenchmarkToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        BenchmarkClientInterface $performanceAuditClient,
        RequestBuilderInterface $requestBuilder,
        BenchmarkToUtilEncodingServiceInterface $utilEncodingService
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
     * @throws \SprykerSdk\Shared\Benchmark\Exception\LoginFailedException
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
