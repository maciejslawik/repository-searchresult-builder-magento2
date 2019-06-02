<?php
declare(strict_types=1);

/**
 * File: RepositorySearchResultBuilderTraitTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\RepositorySearchResultBuilder\Test\Unit\Traits;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\DataObject;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class RepositorySearchResultBuilderTraitTest
 * @package MSlwk\RepositorySearchResultBuilder\Test\Unit\Traits
 */
class RepositorySearchResultBuilderTraitTest extends TestCase
{
    /**
     * @var MockObject|CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var MockObject|SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var RepositoryTestDouble
     */
    private $repository;

    /**
     * @return void
     */
    protected function setUp()
    {
        $this->collectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->searchResultsFactory = $this->getMockBuilder(SearchResultsInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new RepositoryTestDouble($this->collectionFactory, $this->searchResultsFactory);
    }

    /**
     * @test
     */
    public function testGetList()
    {
        $model = new DataObject();

        /** @var MockObject|Collection $collection */
        $collection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $collection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$model]));

        /** @var MockObject|SearchCriteriaInterface $searchCriteria */
        $searchCriteria = $this->getMockBuilder(SearchCriteriaInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sortOrder = $this->getMockBuilder(SortOrder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sortOrder->expects($this->once())
            ->method('getDirection')
            ->will($this->returnValue(SortOrder::SORT_ASC));
        $searchCriteria->expects($this->once())
            ->method('getSortOrders')
            ->will($this->returnValue([$sortOrder]));
        $filterGroup = $this->getMockBuilder(FilterGroup::class)
            ->disableOriginalConstructor()
            ->getMock();
        $searchCriteria->expects($this->once())
            ->method('getFilterGroups')
            ->will($this->returnValue([$filterGroup]));
        $filter = $this->getMockBuilder(Filter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filterGroup->expects($this->once())
            ->method('getFilters')
            ->will($this->returnValue([$filter]));
        $filter->expects($this->once())
            ->method('getField')
            ->will($this->returnValue('user_id'));
        $filter->expects($this->once())
            ->method('getConditionType')
            ->will($this->returnValue('eq'));
        $filter->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('3'));

        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($collection));

        $searchResults = $this->getMockBuilder(SearchResultsInterface::class)
            ->setMethods(
                [
                    'setSearchCriteria',
                    'setItems',
                    'getItems',
                    'setTotalCount',
                    'getTotalCount',
                    'getSearchCriteria'
                ]
            )
            ->getMock();

        $this->searchResultsFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($searchResults));

        $result = $this->repository->getList($searchCriteria);

        $this->assertSame($searchResults, $result);
    }
}
