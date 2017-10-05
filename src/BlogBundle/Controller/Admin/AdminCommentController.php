<?php

namespace BlogBundle\Controller\Admin;

use BlogBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminCommentController extends Controller
{
    /**
     * @Route("/admin/comments", name="admin_comments")
     */
    public function commentsAction(Request $request)
    {
        $commentRepository =$this->getDoctrine()->getRepository("BlogBundle:Comment");
        $totalComment=$commentRepository->findAllCommentCount();

        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $comments = $commentRepository->findComment(["page"=>$page, "max_result" => 10]);
        $pagination = [
            "total" => array_shift($totalComment),
            "page" => $page,
            "max_result" => 10,
            "url" => "admin_comments"
        ];

        return $this->render(
            "BlogBundle:Admin/Comment:admin_view.html.twig",
            [
                "comments"=>$comments,
                'pagination' => $pagination
            ]
        );
    }

    /**
     * @Route("/admin/comment/{id}/delete", name="admin_comment_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository("BlogBundle:Comment")->find($id);

        if (!$comment)
        {
            throw $this->createAccessDeniedException("Такого коментарія не знайдено!");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute("admin_comments");
    }
}