<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\Benchmark\Business\Helper\GuiTable;

use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Psr\Http\Message\ResponseInterface;

interface GuiTableHelperInterface
{
    public const QUERY_PARAM_PAGE = 'page';
    public const QUERY_PARAM_FILTER = 'filter';
    public const QUERY_PARAM_SEARCH = 'search';

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $tableTag
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    public function parseTableConfigFromResponse(
        ResponseInterface $response,
        string $tableTag
    ): GuiTableConfigurationTransfer;

    /**
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $tableConfigTransfer
     * @param string $type
     *
     * @throws \SprykerSdk\Zed\Benchmark\Business\Exception\InvalidGuiTableDataSourceTypeException
     *
     * @return string
     */
    public function getUrlFromDataSource(GuiTableConfigurationTransfer $tableConfigTransfer, string $type): string;

    /**
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $tableConfigTransfer
     *
     * @throws \SprykerSdk\Zed\Benchmark\Business\Exception\InvalidGuiTableFilterTypeException
     *
     * @return array
     */
    public function getAllEnabledFiltersWithFirstValue(GuiTableConfigurationTransfer $tableConfigTransfer): array;
}
