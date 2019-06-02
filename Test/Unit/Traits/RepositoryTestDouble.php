<?php
declare(strict_types=1);

/**
 * File: RepositoryTestDouble.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\RepositorySearchResultBuilder\Test\Unit\Traits;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use MSlwk\RepositorySearchResultBuilder\Traits\RepositorySearchResultBuilderTrait;

/**
 * Class RepositoryTestDouble
 * @package MSlwk\RepositorySearchResultBuilder\Test\Unit\Traits
 */
class RepositoryTestDouble
{
    use RepositorySearchResultBuilderTrait;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * RepositoryTestDouble constructor.
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        return $this->buildSearchResult($searchCriteria, $searchResults, $collection);
    }
}
