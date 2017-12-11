<?php


namespace BlogBundle\Service;

use BlogBundle\Entity\Comment;
use BlogBundle\Filter\CommentFilter;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;

class CommentsService
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * Comments comment.
     *
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param CommentFilter $filter
     *
     * @return mixed
     */
    public function getFilteredComments(CommentFilter $filter)
    {
        /** @var EntityRepository $repo */
        $repo = $this->doctrine->getRepository('BlogBundle:Comment');
        $qb = $repo->createQueryBuilder('c');
        $qb->orderBy('c.id', 'DESC');

        if ($filter->getComment()) {
            $qb->andWhere('c.comment LIKE :comment');
            $qb->setParameter(':comment', "%" . $filter->getComment() . "%");
        }

        return $qb->getQuery();
    }
}