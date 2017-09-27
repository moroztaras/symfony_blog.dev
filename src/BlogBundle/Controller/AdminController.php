<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Blog;
use BlogBundle\Forms\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        return $this->redirectToRoute("admin_blogs");;
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
     * @Route("/admin/blog/create", name="admin_blog_create")
     */
    public function createAction(Request $request)
    {
        $blog = new Blog();
        $forms = $this->createForm(FormType::class, $blog);

        $forms->handleRequest($request);
        if($forms->isSubmitted() && $forms->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute("admin_blogs");
        }

        return $this->render(
            "BlogBundle:Admin:admin_form_create.html.twig",
            [
                "form_create_blog" => $forms->createView()
            ]
        );
    }

    /**
     * @Route("/admin/blog/{id}/edit", name="admin_blog_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository("BlogBundle:Blog")->find($id);

        if (!$blog)
        {
            throw $this->createAccessDeniedException("Такий блог не знайдено!");
        }

        $forms = $this->createForm(FormType::class, $blog);
        $forms->handleRequest($request);
        if($forms->isSubmitted() && $forms->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute("admin_blogs");
        }

        return $this->render(
            "BlogBundle:Admin:admin_form_edit.html.twig",
            [
                "form_edit_blog" => $forms->createView()
            ]
        );
    }

    /**
     * @Route("/admin/blog/{id}/delete", name="admin_blog_delete")
     */
    public function deleteAction($id)
    {
        return new Response($id);
    }
}