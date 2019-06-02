<?php
declare(strict_types=1);

/**
 * File: RepositorySearchResultBuilderTrait.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\RepositorySearchResultBuilder\Traits;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Trait RepositorySearchResultBuilderTrait
 * @package MSlwk\RepositorySearchResultBuilder\Traits
 */
trait RepositorySearchResultBuilderTrait
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param AbstractDb $collection
     */
    protected function addFiltersToCollection(
        SearchCriteriaInterface $searchCriteria,
        AbstractDb $collection
    ): void {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param AbstractDb $collection
     */
    protected function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        AbstractDb $collection
    ): void {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() === SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param AbstractDb $collection
     */
    protected function addPagingToCollection(
        SearchCriteriaInterface $searchCriteria,
        AbstractDb $collection
    ): void {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param SearchResultsInterface $searchResults
     * @param AbstractDb $collection
     * @return SearchResultsInterface
     */
    protected function buildSearchResult(
        SearchCriteriaInterface $searchCriteria,
        SearchResultsInterface $searchResults,
        AbstractDb $collection
    ): SearchResultsInterface {
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
