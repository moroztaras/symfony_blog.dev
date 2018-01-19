<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Forms\Models\RegisterUserModel;
use UserBundle\Forms\RegisterUserForm;
use UserBundle\Forms\Models\RecoverUserModel;
use UserBundle\Forms\RecoverUserForm;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('UserBundle:security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function registerAction(Request $request){
        $registerModel = new RegisterUserModel();
        $registerForm = $this->createForm(RegisterUserForm::class, $registerModel);
        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted()){
            $user = $registerModel->getUserHandler();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('@User/security/register.html.twig',[
            'register_form' => $registerForm->createView()
        ]);
    }

    public  function recoverAction($token, Request $request )
    {
        if($token){
            var_dump($token);
            /** @var UserAccount $userRecover */
            $userAccountRecover = $this->getDoctrine()->getRepository('UserBundle:UserAccount')->findOneByTokenRecover($token);
            if($userAccountRecover){
                $userPasswordToken = new UsernamePasswordToken($userAccountRecover->getUser(), null, 'main',$userAccountRecover->getUser()->getRoles() );
                $this->get('security.token_storage')->setToken($userPasswordToken);
                return $this->redirectToRoute('user_password_recover');
            }
        }
        $recoverModel = new RecoverUserModel();
        $recoverForm = $this->createForm(RecoverUserForm::class, $recoverModel);
        $recoverForm->handleRequest($request);
        if($recoverForm->isSubmitted()){
            $email = $recoverModel->getEmail();
            $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneByEmail($email);
            if($user){
                $this->get('user.security.recover')->send($user);
            }
            var_dump("message send");
            return $this->redirectToRoute('recover');
        }
        return $this->render('@User/security/recover.html.twig',[
            'recover_form' => $recoverForm->createView()
        ]);
    }
}