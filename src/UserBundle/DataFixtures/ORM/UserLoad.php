<?php
namespace UserBundle\DataFixtures\ORM;

use CoreBundle\Core\Core;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Role;
use UserBundle\Entity\User;
use UserBundle\Entity\UserAccount;

class UserLoad implements FixtureInterface {

    public function load(ObjectManager $manager) {

        $roleRepo = $manager->getRepository(Role::class);
        $role = $roleRepo->findOneByRole('USER_ROLE');
        if(!$role)
            return;

        $encoder = Core::service('security.password_encoder');
        $user = new User();
        $password = $encoder->encodePassword($user, 'moroztaras');
        $user->setPassword($password);
        $user->addRole($role);
        $user->setEmail('moroztaras@i.ua');

        $userAccount = new UserAccount();
        $userAccount->setFirstName('Taras')->setLastName('Moroz');
        $userAccount->setBirthday( new \DateTime() );
        $userAccount->setGender('m');

        $em = Core::em();
        $em->beginTransaction();
        try{
            $em->persist($user);
            $em->flush();
            $userAccount->setUser($user);
            $em->persist($userAccount);
            $em->flush();
            $em->commit();
        } catch( \Exception $e ){
            $em->rollback();
        }
    }
    public function getOrder(){
        return 2;
    }
}