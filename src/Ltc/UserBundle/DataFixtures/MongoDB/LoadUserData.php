<?php

namespace Application\UserBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\UserBundle\Document\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $userManager;

    public function getOrder()
    {
        return 0;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManager = $container->get('fos_user.user_manager');
    }

    public function load($manager)
    {
        $user = $this->userManager->createUser();
        $user->setUsername('thibault');
        $user->setEmail('thibault.duplessis@gmail.com');
        $user->setPlainPassword('pass');
        $user->setEnabled(true);
        $user->addRole(User::ROLE_SUPERADMIN);
        $this->userManager->updateUser($user);

        $user = $this->userManager->createUser();
        $user->setUsername('pascal');
        $user->setEmail('pascalDuplessis@aol.com');
        $user->setPlainPassword('pass');
        $user->setEnabled(true);
        $user->addRole(User::ROLE_ADMIN);
        $this->userManager->updateUser($user);
    }
}
