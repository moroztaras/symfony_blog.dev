<?php


namespace BlogBundle\Service;

use BlogBundle\Entity\Message;
use BlogBundle\Filter\MessageFilter;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;

class MessagesService
{

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * Messages message.
     *
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param MessageFilter $filter
     *
     * @return mixed
     */
    public function getFilteredMessages(MessageFilter $filter)
    {
        /** @var EntityRepository $repo */
        $repo = $this->doctrine->getRepository('BlogBundle:Message');
        $qb = $repo->createQueryBuilder('m');
        $qb->orderBy('m.id', 'DESC');

        if ($filter->getName()) {
            $qb->andWhere('m.name LIKE :name');
            $qb->setParameter(':name', "%" . $filter->getName() . "%");
        }

        if ($filter->getMessage()) {
            $qb->andWhere('m.message LIKE :message');
            $qb->setParameter(':message', "%" . $filter->getMessage() . "%");
        }

        return $qb->getQuery();
    }
}