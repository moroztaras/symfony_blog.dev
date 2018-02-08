<?php

namespace BlogBundle\Controller\SonataAdmin;

use UserBundle\Entity\User;
use BlogBundle\Filter\UserFilter;
use BlogBundle\Filter\Form\UserFilterForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SonataAdminUserController extends Controller
{
    /**
     * @Route("/sonata_admin/users", name="sonata_admin_users")
     *
     * @param Request $request
     * @return Response
     */
    public function sonataUsersAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $userAccount = $user->getAccount();

        $paginator = $this->get('knp_paginator');
        $usersService = $this->get('blog.users');
        $sessionService = $this->get('blog.sessions');
        $filter = new UserFilter();

        $form = $this->createForm(UserFilterForm::class, $filter);
        $form->handleRequest($request);

        if(false == $sessionService->updateFilterFromSession($form, $filter)) {
            $this->addFlash('error', 'Помилка в параметрах фільтра');
        }

        $query = $usersService->getFilteredUsers($filter);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render(
            'BlogBundle:SonataAdmin:user\sonata_users.html.twig',
            [
                "userAccount"=>$userAccount,
                'pagination' => $pagination,
                'form' => $form->createView(),
                'filterActive' => $sessionService->getFilterStatus(),
            ]
        );
    }
}