<?php


namespace BlogBundle\Service;

use BlogBundle\Filter\UserFilter;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;

class UsersService
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * Users user.
     *
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param UserFilter $filter
     *
     * @return mixed
     */
    public function getFilteredUsers(UserFilter $filter)
    {
        /** @var EntityRepository $repo */
        $repo = $this->doctrine->getRepository('UserBundle:User');
        $qb = $repo->createQueryBuilder('u');
        $qb->orderBy('u.id', 'DESC');

        if ($filter->getUserName()) {
            $qb->andWhere('u.username LIKE :username');
            $qb->setParameter(':username', "%" . $filter->getUserName() . "%");
        }

        return $qb->getQuery();
    }
}