<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    /**
     * @param $username
     * @param $passwordHash
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUsernameOrEmail($username, $passwordHash)
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->where($qb->expr()->orX(
                $qb->expr()->eq('u.username', ':username'),
                $qb->expr()->eq('u.email', ':email')
            ))
            ->andWhere($qb->expr()->eq('u.password', ':password'))
            ->setParameters([
                ':username' => $username,
                ':email' => $username,
                ':password' => $passwordHash
            ]);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
