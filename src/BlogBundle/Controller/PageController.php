<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Message;
use BlogBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PageController extends Controller
{
    /**
     * @Route("/about_us", name="about_us")
     */
    public function aboutUsAction(Request $request)
    {
        $message = new Message();
        $forms = $this->createForm(MessageType::class, $message);

        $forms->handleRequest($request);
        if($forms->isSubmitted() && $forms->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute("about_us");
        }

        return $this->render(
            "BlogBundle:Page:about_us.html.twig",
            [
                "form_create_message" => $forms->createView()
            ]
        );
    }
}