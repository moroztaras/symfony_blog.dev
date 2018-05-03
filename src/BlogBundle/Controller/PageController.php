<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Message;
use BlogBundle\Form\MessageType;
use BlogBundle\Event\MessageEvent;
use BlogBundle\BlogBundleEvents;
use BlogBundle\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;

class PageController extends Controller
{
    /**
     * @Route("/about_us", name="about_us")
     */
    public function aboutUsAction(Request $request)
    {
        $mailer = $this->get('blog.mailer');
        $message = new Message();
        $forms = $this->createForm(MessageType::class, $message);

        $forms->handleRequest($request);
        if($forms->isSubmitted() && $forms->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $mailer->send(
                'Надіслано нове повідомлення!',
                'moroztaras@i.ua',
                'BlogBundle:Email:message_email.html.twig',
                []
            );

            $dispatcher = $this->get('event_dispatcher');
            $event = new MessageEvent($message);
            $dispatcher->dispatch(BlogBundleEvents::MESSAGE_CREATE, $event);

            return $this->redirectToRoute("about_us");
        }

        return $this->render(
            "BlogBundle:Page:about_us.html.twig",
            [
                "form_create_message" => $forms->createView()
            ]
        );
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('BlogBundle:Blog')->getTags();
        $tagWeights = $em->getRepository('BlogBundle:Blog')->getTagWeights($tags);
        $commentLimit   = 10; # $this->container->getParameter('blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BlogBundle:Comment')->getLatestComments($commentLimit);
        return $this->render('BlogBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights
        ));
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $blogRepository = $this->getDoctrine()->getRepository("BlogBundle:Blog");
        $searchForm = $this->createForm(SearchForm::class);
        $searchForm->handleRequest($request);
        $blogs = null;

        if($request->query->get("search")) {
            $data = $request->query->get("search");
            $blogs = $blogRepository->findByWord($data);
            unset($request);
        }

        if($searchForm->isSubmitted())
        {
            $data = $searchForm->getData();
            $blogs = $blogRepository->findByWord($data["search"]);
        }

        return $this->render(
            'BlogBundle:Blog:search.html.twig',[
            'blogs'=>$blogs,
            'searchForm' => $searchForm->createView(),
            'count' => count($blogs),
        ]);
    }

    /**
     * @Route("/tag/{tag}", name="tag")
     */
    public function tagAction($tag)
    {
        $blogRepository = $this->getDoctrine()->getRepository("BlogBundle:Blog");
        $blogs = null;
        $blogs = $blogRepository->findByTag($tag);

        return $this->render(
            'BlogBundle:Blog:tag.html.twig',[
            'blogs'=>$blogs,
        ]);
    }

    public function userAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $userAccount = $user->getAccount();

        return $this->render('@Blog/user.html.twig',[
            'userAccount' => $userAccount,
            'user' => $user
        ]);
    }
}