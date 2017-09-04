<?php

namespace BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PageController extends Controller
{
    /**
     * @Route("/about_us", name="about_us")
     */
    public function aboutUsAction()
    {
        return $this->render("BlogBundle:Page:about_us.html.twig");
    }
}