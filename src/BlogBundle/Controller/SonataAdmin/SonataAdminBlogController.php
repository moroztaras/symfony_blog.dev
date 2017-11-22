<?php

namespace BlogBundle\Controller\SonataAdmin;

use BlogBundle\Entity\Blog;
use BlogBundle\Form\SonataBlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SonataAdminBlogController extends Controller
{

    /**
     * @Route("/sonata_admin", name="sonata_admin")
     */
    public function sobataAdminAction()
    {
        return $this->redirectToRoute('sonata_admin_blogs');
    }
    /**
     * @Route("/sonata_admin/blogs", name="sonata_admin_blogs")
     */
    public function sonataBlogsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository('BlogBundle:Blog')->getLatestBlogs();

        return $this->render(
            'BlogBundle:SonataAdmin:blog\sonata_blogs.html.twig', array(
            'blogs'      => $blogs,
        ));
    }

    /**
     * @Route("/sonata_admin/blog/create", name="sonata_admin_blog_create")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->createForm(SonataBlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('notice', 'Блог добавлений.');

            return $this->redirectToRoute('sonata_admin_blogs');
        }

        return $this->render(
            'BlogBundle:SonataAdmin:blog\sonata_blog_form.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Добавлення блогу',
            ]
        );
    }

    /**
     * @Route("/sonata_admin/blog/{id}/edit", name="sonata_admin_blog_edit")
     * @ParamConverter("blog", class="BlogBundle:Blog")
     * @param Request    $request
     * @param Blog $blog
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Blog $blog)
    {
        $form = $this->createForm(SonataBlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('notice', 'Зміни збережено.');

            return $this->redirectToRoute('sonata_admin_blogs');
        }

        return $this->render(
            'BlogBundle:SonataAdmin:blog\sonata_blog_form.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Редагування блогу',
            ]
        );
    }

    /**
     * @Route("/sonata_admin/blog/{id}/delete", name="sonata_admin_blog_delete")
     * @ParamConverter("blog", class="BlogBundle:Blog")
     * @param Blog $blog
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Blog $blog)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();

        $this->addFlash('notice', 'Блог видалений.');

        return $this->redirectToRoute('sonata_admin_blogs');
    }
}