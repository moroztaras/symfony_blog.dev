<?php

namespace BlogBundle\Controller\SonataAdmin;

use BlogBundle\Entity\Comment;
use BlogBundle\Filter\CommentFilter;
use BlogBundle\Filter\Form\CommentFilterForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SonataAdminCommentController extends Controller
{
    /**
     * @Route("/sonata_admin/comments", name="sonata_admin_comments")
     *
     * @param Request $request
     * @return Response
     */
    public function sonataCommentAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $commentsService = $this->get('blog.comments');
        $sessionService = $this->get('blog.sessions');
        $filter = new CommentFilter();

        $form = $this->createForm(CommentFilterForm::class, $filter);
        $form->handleRequest($request);

        if(false == $sessionService->updateFilterFromSession($form, $filter)) {
            $this->addFlash('error', 'Помилка в параметрах фільтра');
        }

        $query = $commentsService->getFilteredComments($filter);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render(
            'BlogBundle:SonataAdmin:comment\sonata_comments.html.twig',
            [
                'pagination' => $pagination,
                'form' => $form->createView(),
                'filterActive' => $sessionService->getFilterStatus(),
            ]
        );
#        $em = $this->getDoctrine()->getManager();
#        $comments = $em->getRepository("BlogBundle:Comment")->findAll();

#        return $this->render(
#            'BlogBundle:SonataAdmin:comment\sonata_comments.html.twig', array(
#            'comments'      => $comments
#        ));
    }

    /**
     * @Route("/sonata_admin/comment/{id}/delete", name="sonata_admin_comment_delete")
     * @ParamConverter("comment", class="BlogBundle:Comment")
     * @param Comment $comment
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        $this->addFlash('notice', 'Коментарій видалений.');

        return $this->redirectToRoute('sonata_admin_comments');
    }
}