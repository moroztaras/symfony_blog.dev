<?php

namespace BlogBundle\Controller\SonataAdmin;

use BlogBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SonataAdminMessageController extends Controller
{
    /**
     * @Route("/sonata_admin/messages", name="sonata_admin_messages")
     */
    public function sonataMessageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository("BlogBundle:Message")->findAll();

        return $this->render(
            'BlogBundle:SonataAdmin:message\sonata_messages.html.twig', array(
            'messages'      => $messages
        ));
    }

    /**
     * @Route("/sonata_admin/message/{id}/view", name="sonata_admin_message_view")
     */
    public function sonataMessageViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository("BlogBundle:Message")->find($id);

        return $this->render(
            'BlogBundle:SonataAdmin:message\sonata_message_view.html.twig', array(
            'message'      => $message
        ));
    }

    /**
     * @Route("/sonata_admin/message/{id}/delete", name="sonata_admin_message_delete")
     * @ParamConverter("message", class="BlogBundle:Message")
     * @param Message $message
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Message $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        $this->addFlash('notice', 'Повідомлення видалено.');

        return $this->redirectToRoute('sonata_admin_messages');
    }
}