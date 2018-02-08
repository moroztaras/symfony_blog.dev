<?php
namespace UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)->setParameter('email', $username)
            ->getQuery()->getOneOrNullResult();
    }

    public function findAllUserCount()
    {
        $query=$this->createQueryBuilder("u");
        $query->select("count(u)");

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findUser(array $context = [])
    {
        $query=$this->createQueryBuilder("u");
        $query->select("u");
        $max_result = 5;
        if(isset($context["max_result"]) && $context["max_result"] >1)
        {
            $max_result=$context["max_result"];
        }
        $query->setMaxResults($max_result);
        $query->orderBy("u.id", "DESC");

        $page = 0;
        if (isset($context["page"]) && is_numeric($context["page"]) && $context["page"] > 1 )
        {
            $page = $max_result * ($context["page"] - 1);
        }

        $query->setFirstResult($page);
        return $query->getQuery()->getResult();
    }
}