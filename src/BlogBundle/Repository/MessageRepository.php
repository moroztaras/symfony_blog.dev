<?php

namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function findAllMessageCount()
    {
        $query=$this->createQueryBuilder("m");
        $query->select("count(m)");

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findMessage(array $context = [])
    {
        $query=$this->createQueryBuilder("m");
        $query->select("m");
        $max_result = 5;
        if(isset($context["max_result"]) && $context["max_result"] >1)
        {
            $max_result=$context["max_result"];
        }
        $query->setMaxResults($max_result);
        $query->orderBy("m.id", "DESC");

        $page = 0;
        if (isset($context["page"]) && is_numeric($context["page"]) && $context["page"] > 1 )
        {
            $page = $max_result * ($context["page"] - 1);
        }

        $query->setFirstResult($page);
        return $query->getQuery()->getResult();
    }
}