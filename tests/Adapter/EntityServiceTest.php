<?php
/**
 * Polder Knowledge / entityservice-zend-paginator (https://polderknowledge.com)
 *
 * @link https://github.com/polderknowledge/entityservice-zend-paginator for the canonical source repository
 * @copyright Copyright (c) 2016 Polder Knowledge (https://polderknowledge.com)
 * @license https://github.com/polderknowledge/entityservice-zend-paginator/blob/master/LICENSE.md MIT
 */

namespace PolderKnowledge\EntityService\PaginatorTest\Adapter;

use Doctrine\Common\Collections\Criteria;
use PHPUnit_Framework_TestCase;
use PolderKnowledge\EntityService\EntityServiceInterface;
use PolderKnowledge\EntityService\Paginator\Adapter\EntityService;

class EntityServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers PolderKnowledge\EntityService\Paginator\Adapter\EntityService::__construct
     * @covers PolderKnowledge\EntityService\Paginator\Adapter\EntityService::count
     */
    public function testCount()
    {
        // Arrange
        $entityService = $this->getMockForAbstractClass(EntityServiceInterface::class);
        $entityService->expects($this->once())->method('countBy')->willReturn(123);

        $paginator = new EntityService($entityService);

        // Act
        $result = $paginator->count();

        // Assert
        $this->assertEquals(123, $result);
    }

    /**
     * @covers PolderKnowledge\EntityService\Paginator\Adapter\EntityService::__construct
     * @covers PolderKnowledge\EntityService\Paginator\Adapter\EntityService::getItems
     */
    public function testGetItems()
    {
        // Arrange
        $criteriaBuilder = $this->getMockBuilder(Criteria::class);
        $criteriaBuilder->setMethods(['setFirstResult', 'setMaxResults']);

        $criteria = $criteriaBuilder->getMockForAbstractClass();
        $criteria->expects($this->once())->method('setFirstResult')->with(10);
        $criteria->expects($this->once())->method('setMaxResults')->with(20);

        $entityService = $this->getMockForAbstractClass(EntityServiceInterface::class);
        $entityService->expects($this->never())->method('countBy');
        $entityService->expects($this->once())->method('findBy')->willReturn([]);

        $paginator = new EntityService($entityService, $criteria);

        // Act
        $result = $paginator->getItems(10, 20);

        // Assert
        $this->assertEquals([], $result);
    }
}
