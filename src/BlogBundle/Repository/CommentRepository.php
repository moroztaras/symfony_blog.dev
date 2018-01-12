<?php

namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getCommentsForBlog($blogId, $approved = true)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.blog = :blog_id')
            ->addOrderBy('c.created')
            ->setParameter('blog_id', $blogId);

        if (false === is_null($approved))
            $qb->andWhere('c.approved = :approved')
                ->setParameter('approved', $approved);

        return $qb->getQuery()->getResult();
    }

    public function findAllCommentCount()
    {
        $query=$this->createQueryBuilder("c");
        $query->select("count(c)");

        return $query->getQuery()->getOneOrNullResult();
    }

    public function findComment(array $context = [])
    {
        $query=$this->createQueryBuilder("c");
        $query->select("c");
        $max_result = 5;
        if(isset($context["max_result"]) && $context["max_result"] >1)
        {
            $max_result=$context["max_result"];
        }
        $query->setMaxResults($max_result);
        $query->orderBy("c.id", "DESC");

        $page = 0;
        if (isset($context["page"]) && is_numeric($context["page"]) && $context["page"] > 1 )
        {
            $page = $max_result * ($context["page"] - 1);
        }

        $query->setFirstResult($page);
        return $query->getQuery()->getResult();
    }

    public function getLatestComments($limit = 10)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->addOrderBy('c.id', 'DESC');
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        return $qb->getQuery()
            ->getResult();
    }
}