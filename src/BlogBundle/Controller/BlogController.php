<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine();
        $blogRepository = $em->getRepository('BlogBundle:Blog');

        $blogs = $blogRepository->findAll();;

        return $this->render(
            'BlogBundle:Blog:index.html.twig',[
            'blogs'=>$blogs
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_view")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine();
        $blogRepository = $em->getRepository('BlogBundle:Blog');

        $blog = $blogRepository->find($id);;

        return $this->render(
            'BlogBundle:Blog:view.html.twig',[
                'blog'=>$blog
        ]);
    }
}