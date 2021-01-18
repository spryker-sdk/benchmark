<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\Benchmark\Helper\GuiTable;

use DateTime;
use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableFilterTransfer;
use Psr\Http\Message\ResponseInterface;
use Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface;
use SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface;
use SprykerSdk\Zed\Benchmark\Business\Exception\InvalidGuiTableDataSourceTypeException;
use SprykerSdk\Zed\Benchmark\Business\Exception\InvalidGuiTableFilterTypeException;

class GuiTableHelper implements GuiTableHelperInterface
{
    /**
     * @var \SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface
     */
    protected $domHelper;

    /**
     * @param \SprykerSdk\Shared\Benchmark\Helper\Html\DomHelperInterface $domHelper
     */
    public function __construct(DomHelperInterface $domHelper)
    {
        $this->domHelper = $domHelper;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $tableTag
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    public function parseTableConfigFromResponse(
        ResponseInterface $response,
        string $tableTag
    ): GuiTableConfigurationTransfer {
        $domDocument = $this->domHelper->buildDOMDocumentFromResponse($response);

        $tableDomElement = $this->domHelper->getFirstElementByTag($domDocument, $tableTag);
        $tableConfigJson = $tableDomElement->getAttribute('table-config');

        return $this->mapTableConfigDataToGuiTableConfigurationTransfer(
            json_decode($tableConfigJson, true),
            new GuiTableConfigurationTransfer()
        );
    }

    /**
     * @param array $tableConfigData
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $tableConfigTransfer
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    protected function mapTableConfigDataToGuiTableConfigurationTransfer(
        array $tableConfigData,
        GuiTableConfigurationTransfer $tableConfigTransfer
    ): GuiTableConfigurationTransfer {
        $tableConfigTransfer->fromArray($tableConfigData, true);

        foreach ($tableConfigData as $key => $value) {
            if (!array_key_exists('enabled', $value)) {
                continue;
            }
            $nestedTransfer = $tableConfigTransfer->offsetGet($key);
            if (method_exists($nestedTransfer, 'setIsEnabled')) {
                $nestedTransfer->setIsEnabled($value['enabled']);
            }
        }

        return $tableConfigTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $tableConfigTransfer
     * @param string $type
     *
     * @throws \SprykerSdk\Zed\Benchmark\Business\Exception\InvalidGuiTableDataSourceTypeException
     *
     * @return string
     */
    public function getUrlFromDataSource(GuiTableConfigurationTransfer $tableConfigTransfer, string $type): string
    {
        $dataSource = $tableConfigTransfer->getDataSource();
        if (!$dataSource->getType() === $type) {
            throw new InvalidGuiTableDataSourceTypeException(
                sprintf('Unknown dataSource type "%s".', $type)
            );
        }

        return $dataSource->getUrl();
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableConfigurationTransfer $tableConfigTransfer
     *
     * @return array
     */
    public function getAllEnabledFiltersWithFirstValue(GuiTableConfigurationTransfer $tableConfigTransfer): array
    {
        $filtersConfigTransfer = $tableConfigTransfer->getFilters();
        if (!$filtersConfigTransfer->getIsEnabled() === true) {
            return [];
        }

        $filtersWithValues = [];
        foreach ($filtersConfigTransfer->getItems() as $filterTransfer) {
            $filtersWithValues[$filterTransfer->getId()] = $this->createValueForFilter($filterTransfer);
        }

        return $filtersWithValues;
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableFilterTransfer $filterTransfer
     *
     * @throws \SprykerSdk\Zed\Benchmark\Business\Exception\InvalidGuiTableFilterTypeException
     *
     * @return array|string
     */
    protected function createValueForFilter(GuiTableFilterTransfer $filterTransfer)
    {
        switch ($filterTransfer->getType()) {
            case GuiTableConfigurationBuilderInterface::FILTER_TYPE_DATE_RANGE:
                return $this->createValueForDateRangeFilter($filterTransfer);
            case GuiTableConfigurationBuilderInterface::FILTER_TYPE_SELECT:
            case GuiTableConfigurationBuilderInterface::FILTER_TYPE_TREE_SELECT:
                return $this->createValueForSelectFilter($filterTransfer);
            default:
                throw new InvalidGuiTableFilterTypeException(
                    sprintf('Invalid table config filter type "%s".', $filterTransfer->getType())
                );
        }
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableFilterTransfer $filterTransfer
     *
     * @return array
     */
    protected function createValueForDateRangeFilter(GuiTableFilterTransfer $filterTransfer): array
    {
        $dateTo = new DateTime();
        $dateFrom = (new DateTime())->modify('-100days');

        return [
            'from' => $dateFrom->format('Y-m-d\TH:i:s.v\Z'),
            'to' => $dateTo->format('Y-m-d\TH:i:s.v\Z'),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\GuiTableFilterTransfer $filterTransfer
     *
     * @return int|string|array
     */
    protected function createValueForSelectFilter(GuiTableFilterTransfer $filterTransfer)
    {
        $isMultiselect = $filterTransfer->getTypeOptions()['multiselect'];
        $firstValue = reset($filterTransfer->getTypeOptions()['values']);
        $value = $firstValue['value'];

        if ($isMultiselect === true) {
            return [$value];
        }

        return $value;
    }
}
