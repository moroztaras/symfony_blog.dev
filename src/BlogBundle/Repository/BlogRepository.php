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

    public function getTags()
    {
        $blogTags = $this->createQueryBuilder('b')
            ->select('b.tags')
            ->getQuery()
            ->getResult();
        $tags = array();
        foreach ($blogTags as $blogTag)
        {
            $tags = array_merge(explode(",", $blogTag['tags']), $tags);
        }
        foreach ($tags as &$tag)
        {
            $tag = trim($tag);
        }
        return $tags;
    }

    public function getTagWeights($tags)
    {
        $tagWeights = array();
        if (empty($tags))
            return $tagWeights;
        foreach ($tags as $tag)
        {
            $tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag] + 1 : 1;
        }
        // Shuffle the tags
        uksort($tagWeights, function() {
            return rand() > rand();
        });
        $max = max($tagWeights);
        // Max of 5 weights
        $multiplier = ($max > 5) ? 5 / $max : 1;
        foreach ($tagWeights as &$tag)
        {
            $tag = ceil($tag * $multiplier);
        }
        return $tagWeights;
    }

    public function findByWord($word)
    {
        $qb=$this->createQueryBuilder('b')->where('b.title LIKE :word')->orWhere('b.summary LIKE :word')->orWhere('b.body LIKE :word')->orWhere('b.tags LIKE :word');
        $qb->setParameter('word', '%'.$word.'%');
        $qb->setMaxResults(20);

        return $qb->getQuery()
            ->getResult();
    }
}