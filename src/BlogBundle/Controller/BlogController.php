<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();
        $blogRepository = $em->getRepository('BlogBundle:Blog');

        $totalBlog=$blogRepository->findAllBlogCount();

        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $blogs = $blogRepository->findBlog(["page"=>$page]);
        $pagination = [
          "total" => array_shift($totalBlog),
          "page" => $page,
          "max_result" => 5,
          "url" => "homepage"
        ];
        return $this->render(
            'BlogBundle:Blog:index.html.twig',[
            'blogs'=>$blogs,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_view")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine();
        $blogRepository = $em->getRepository('BlogBundle:Blog');

        $blog = $blogRepository->find($id);

        return $this->render(
            'BlogBundle:Blog:view.html.twig',[
                'blog'=>$blog
        ]);
    }
}