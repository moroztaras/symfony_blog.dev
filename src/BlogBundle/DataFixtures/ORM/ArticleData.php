<?php

namespace AppBundle\DataFixtures\ORM;

use BlogBundle\Entity\Blog;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $blog = new Blog();
        $blog->setTitle('Перший тестовий пост. Запуск блогу "Блог 2018"');
        $blog->setBody('Цей блог було створено спеціально для удосконалення поглиблиблених знань на framework Symfony3.
При розробці архітектури цього проекту, блог було розроблено три інтерфейси: 
front end -інтефейс користува;
back end - програмно-апаратна частина.
Адмін панель створено два вида: custom admin panel; SonataAdmin');
        $blog->setSummary('Цей блог було створено спеціально для удосконалення поглиблиблених знань на framework Symfony3. 
        При розробці архітектури цього проекту, блог було розроблено три інтерфейси: 
front end -інтефейс користува;
back end - програмно-апаратна частина.
Адмін панель створено два вида: custom admin panel; SonataAdmin');
        $blog->setTags('блог 2018, перша стаття, запуск блога, тестовий пост');

        $manager->persist($blog);
        $manager->flush();
    }
}