<?php
namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Forms\ChangePasswordForm;
use UserBundle\Forms\Models\ChangePasswordModel;
use UserBundle\Forms\UserAccountForm;
use UserBundle\UserBundleEvents;
use UserBundle\Event\UserEvent;

class UserController extends Controller
{
    public function recoverPasswordAction( Request $request )
    {
        /** @var User $user */
        $user = $this->getUser();
        $userAccount = $user->getAccount();
        if(!$userAccount->getTokenRecover())
            return $this->redirectToRoute('user_profile');
        $changePasswordModel = new ChangePasswordModel();
        $formChangePassword = $this->createForm(ChangePasswordForm::class, $changePasswordModel);
        $formChangePassword->handleRequest($request);
        if($formChangePassword->isSubmitted() && $formChangePassword->isValid()){
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $changePasswordModel->password);
            $user->setPassword($password);
            $userAccount->setTokenRecover('null');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $dispatcher = $this->get('event_dispatcher');
            $event = new UserEvent($user);
            $dispatcher->dispatch(UserBundleEvents::USER_RECOVER_PASSWORD, $event);

            return $this->redirectToRoute('user_profile');
        }
        return $this->render('@User/security/recover.html.twig',[
            'recover_form' => $formChangePassword->createView()
        ]);
    }

    public function profileAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $userAccount = $user->getAccount();
        $count_blogs = count($user->getBlogs());

        return $this->render('@User/security/profile.html.twig',[
            'userAccount' => $userAccount,
            'count_blogs' => $count_blogs,
            'user' => $user
        ]);
    }

    public function userProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        $count_blogs = count($user->getBlogs());
        $userAccount = $user->getAccount();

        return $this->render('@User/security/user_profile.html.twig',[
            'userAccount' => $userAccount,
            'count_blogs' => $count_blogs,
            'user' => $user
        ]);
    }

    public function userBlogsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        $blogs = $user->getBlogs();
        return $this->render(
            '@User/security/user_blogs.html.twig',[
            'blogs'=>$blogs
        ]);
    }

    public function editAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $userAccount = $user->getAccount();
        $form = $this->createForm(UserAccountForm::class, $userAccount);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userAccount);
            $em->flush();

            $dispatcher = $this->get('event_dispatcher');
            $event = new UserEvent($user);
            $dispatcher->dispatch(UserBundleEvents::USER_EDIT, $event);

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('@User/security/edit.html.twig',[
            'userAccount' => $form->createView()
        ]);
    }
}