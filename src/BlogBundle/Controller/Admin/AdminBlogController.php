<?php

namespace BlogBundle\Controller\Admin;

use BlogBundle\Entity\Blog;
use BlogBundle\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminBlogController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        return $this->redirectToRoute("admin_blogs");
    }

    /**
     * @Route("/admin/blogs", name="admin_blogs")
     */
    public function blogsAction(Request $request)
    {
        $blogRepository =$this->getDoctrine()->getRepository("BlogBundle:Blog");
        $totalBlog=$blogRepository->findAllBlogCount();

        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $blogs = $blogRepository->findBlog(["page"=>$page, "max_result" => 10]);
        $pagination = [
            "total" => array_shift($totalBlog),
            "page" => $page,
            "max_result" => 10,
            "url" => "admin_blogs"
        ];

        return $this->render(
            "BlogBundle:Admin/Blog:admin_view.html.twig",
            [
                "blogs"=>$blogs,
                'pagination' => $pagination
            ]
        );
    }

    /**
     * @Route("/admin/blog/create", name="admin_blog_create")
     */
    public function createAction(Request $request)
    {
        $blog = new Blog();
        $forms = $this->createForm(BlogType::class, $blog);

        $forms->handleRequest($request);
        if($forms->isSubmitted() && $forms->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute("admin_blogs");
        }

        return $this->render(
            "BlogBundle:Admin/Blog:admin_form_create.html.twig",
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

        $forms = $this->createForm(BlogType::class, $blog);
        $forms->handleRequest($request);
        if($forms->isSubmitted() && $forms->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute("admin_blogs");
        }

        return $this->render(
            "BlogBundle:Admin/Blog:admin_form_edit.html.twig",
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
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository("BlogBundle:Blog")->find($id);

        if (!$blog)
        {
            throw $this->createAccessDeniedException("Такий блог не знайдено!");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();

        return $this->redirectToRoute("admin_blogs");
    }
}