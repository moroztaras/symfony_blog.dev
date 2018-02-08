<?php

namespace BlogBundle\Controller\SonataAdmin;

use BlogBundle\Entity\Message;
use BlogBundle\Filter\MessageFilter;
use BlogBundle\Filter\Form\MessageFilterForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SonataAdminMessageController extends Controller
{
    /**
     * @Route("/sonata_admin/messages", name="sonata_admin_messages")
     *
     * @param Request $request
     * @return Response
     */
    public function sonataMessageAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $messagesService = $this->get('blog.messages');
        $sessionService = $this->get('blog.sessions');
        $filter = new MessageFilter();

        $form = $this->createForm(MessageFilterForm::class, $filter);
        $form->handleRequest($request);

        if(false == $sessionService->updateFilterFromSession($form, $filter)) {
            $this->addFlash('error', 'Помилка в параметрах фільтра');
        }

        $query = $messagesService->getFilteredMessages($filter);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render(
            'BlogBundle:SonataAdmin:message\sonata_messages.html.twig',
            [
                'pagination' => $pagination,
                'form' => $form->createView(),
                'filterActive' => $sessionService->getFilterStatus(),
            ]
        );
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