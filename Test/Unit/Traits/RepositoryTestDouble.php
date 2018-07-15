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
use MSlwk\RepositorySearchResultBuilder\Traits\RepositorySearchResultBuilderTrait;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;
use Magento\Framework\Data\SearchResultInterfaceFactory;

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
     * @var SearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * RepositoryTestDouble constructor.
     * @param CollectionFactory $collectionFactory
     * @param SearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        SearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        /** @var SearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        return $this->buildSearchResult($searchCriteria, $searchResults, $collection);
    }
}
