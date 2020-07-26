<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCount()
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('count(t.id)');
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $sortBy
     * @param string $sortDir
     * @return mixed
     */
    public function findItemsList(int $limit = 20, int $offset = 0, string $sortBy = 'id', string $sortDir = 'ASC')
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->orderBy('t.' . $sortBy, $sortDir)
            ->addOrderBy('t.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
