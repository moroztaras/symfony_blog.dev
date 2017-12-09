<?php


namespace BlogBundle\Service;

use BlogBundle\Entity\Blog;
use BlogBundle\Filter\BlogFilter;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;

class BlogsService
{

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * Blogs blog.
     *
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param BlogFilter $filter
     *
     * @return mixed
     */
    public function getFilteredBlogs(BlogFilter $filter)
    {
        /** @var EntityRepository $repo */
        $repo = $this->doctrine->getRepository('BlogBundle:Blog');
        $qb = $repo->createQueryBuilder('b');
        $qb->orderBy('b.id', 'DESC');

        if ($filter->getTitle()) {
            $qb->andWhere('b.title LIKE :title');
            $qb->setParameter(':title', "%" . $filter->getTitle() . "%");
        }

        return $qb->getQuery();
    }
}