<?php

namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BlogRepository extends EntityRepository
{
    public function findAllBlogCount()
    {
        $query=$this->createQueryBuilder("b");
        $query->select("count(b)");

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findBlog(array $context = [])
    {
        $query=$this->createQueryBuilder("b");
        $query->select("b");
        $max_result = 5;
        if(isset($context["max_result"]) && $context["max_result"] >1)
        {
            $max_result=$context["max_result"];
        }
        $query->setMaxResults($max_result);
        $query->orderBy("b.id", "DESC");

        $page = 0;
        if (isset($context["page"]) && is_numeric($context["page"]) && $context["page"] > 1 )
        {
            $page = $max_result * ($context["page"] - 1);
        }

        $query->setFirstResult($page);
        return $query->getQuery()->getResult();
    }

    public function getLatestBlogs($limit = null)
    {
        $qb = $this->createQueryBuilder('blog')
            ->select('blog')
            ->addOrderBy('blog.created', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
            ->getResult();
    }
}