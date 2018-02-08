<?php

namespace BlogBundle\Controller\Admin;

use UserBundle\Entity\User;
use UserBundle\Entity\UserAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdminUserController extends Controller
{
    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function usersAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $userAccount = $user->getAccount();

        $userRepository =$this->getDoctrine()->getRepository("UserBundle:User");
        $totalUser=$userRepository->findAllUserCount();

        $page = $request->query->get("page") && $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $users = $userRepository->findUser(["page"=>$page, "max_result" => 10]);
        $pagination = [
            "total" => array_shift($totalUser),
            "page" => $page,
            "max_result" => 10,
            "url" => "admin_users"
        ];

        return $this->render(
            "BlogBundle:Admin/User:admin_users.html.twig",
            [
                "users"=>$users,
                "userAccount"=>$userAccount,
                'pagination' => $pagination
            ]
        );
    }
}