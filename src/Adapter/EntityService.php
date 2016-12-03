<?php
/**
 * Polder Knowledge / entityservice-zend-paginator (https://polderknowledge.com)
 *
 * @link https://github.com/polderknowledge/entityservice-zend-paginator for the canonical source repository
 * @copyright Copyright (c) 2016 Polder Knowledge (https://polderknowledge.com)
 * @license https://github.com/polderknowledge/entityservice-zend-paginator/blob/master/LICENSE.md MIT
 */

namespace PolderKnowledge\EntityService\Paginator\Adapter;

use Doctrine\Common\Collections\Criteria;
use PolderKnowledge\EntityService\EntityServiceInterface;
use Zend\Paginator\Adapter\AdapterInterface;

/**
 * Paginator adapter for EntityServices
 */
class EntityService implements AdapterInterface
{
    /**
     * EntityService used to fetch adapter
     *
     * @var EntityServiceInterface
     */
    private $entityService;

    /**
     * Criteria used to fetch entities
     *
     * @var array|Criteria
     */
    private $criteria;

    /**
     * Creates a new instance of this class
     *
     * @param EntityServiceInterface $entityService
     * @param Criteria $criteria The criteria to match.
     * @param array $order
     */
    public function __construct(EntityServiceInterface $entityService, Criteria $criteria = null)
    {
        $this->entityService = $entityService;
        $this->criteria = is_object($criteria) ? clone $criteria : Criteria::create();
    }

    /**
     * {@inhericDoc}
     *
     * @return int
     */
    public function count()
    {
        return $this->entityService->countBy($this->criteria);
    }

    /**
     * {@inhericDoc}
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->criteria->setFirstResult($offset);
        $this->criteria->setMaxResults($itemCountPerPage);

        return $this->entityService->findBy($this->criteria);
    }
}
