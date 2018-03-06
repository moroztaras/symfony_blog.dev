<?php

namespace PiccoloBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function logoAction()
    {
        return $this->render('@Piccolo/Block/logo.html.twig');
    }

    public function mainMenuAction()
    {
        return $this->render('@Piccolo/Block/main-menu.html.twig');
    }

    public function mainMenuFooterAction()
    {
        return $this->render('@Piccolo/Block/main-menu-footer.html.twig');
    }

    public function categoryAction(){
        return $this->render('@Piccolo/Block/category-list.html.twig');
    }
}