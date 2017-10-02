<?php

namespace BlogBundle\Controller\Admin;

use BlogBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminMessageController extends Controller
{
    /**
     * @Route("/admin/messages", name="admin_messages")
     */
    public function messagesAction(Request $request)
    {
        $messageRepository =$this->getDoctrine()->getRepository("BlogBundle:Message");
        $totalMessage=$messageRepository->findAllMessageCount();

        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $messages = $messageRepository->findMessage(["page"=>$page, "max_result" => 10]);
        $pagination = [
            "total" => array_shift($totalMessage),
            "page" => $page,
            "max_result" => 10,
            "url" => "admin_messages"
        ];

        return $this->render(
            "BlogBundle:Admin/Message:admin_index.html.twig",
            [
                "messages"=>$messages,
                'pagination' => $pagination
            ]
        );
    }

    /**
     * @Route("/admin/message/{id}", name="admin_message_view")
     */
    public function showMessageAction($id)
    {
        $em = $this->getDoctrine();
        $messageRepository = $em->getRepository('BlogBundle:Message');

        $message = $messageRepository->find($id);

        return $this->render(
            'BlogBundle:Admin/Message:view.html.twig', [
            'message'=>$message
        ]);
    }

    /**
     * @Route("/admin/message/{id}/delete", name="admin_message_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository("BlogBundle:Message")->find($id);

        if (!$message)
        {
            throw $this->createAccessDeniedException("Такого повідомленняи не знайдено!");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("admin_messages");
    }

}