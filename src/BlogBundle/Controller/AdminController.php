<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        return new Response("HERE");
    }

    /**
     * @Route("/admin/blogs", name="admin_blogs")
     */
    public function blogsAction()
    {
        $blogs = $this->getDoctrine()->getRepository("BlogBundle:Blog")->findAll();

        return $this->render(
            "BlogBundle:Admin:admin_view.html.twig", [
                "blogs"=>$blogs
                ]
        );
    }

    /**
     * @Route("/admin/blog/{id}/edit", name="admin_blog_edit")
     */
    public function editAction($id)
    {
        return new Response($id);
    }

    /**
     * @Route("/admin/blog/{id}/delete", name="admin_blog_delete")
     */
    public function deleteAction($id)
    {
        return new Response($id);
    }
}