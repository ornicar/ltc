<?php

namespace Ltc\ImportBundle\Db;

use Ltc\UserBundle\Document\User;

class UserImporter extends AbstractImporter
{
    protected $userManager;

    public function setUserManager($userManager)
    {
        $this->userManager = $userManager;
    }

    public function import()
    {
        $user = $this->userManager->createUser();
        $user->setUsername('Thibault');
        $user->setEmail('thibault.duplessis@gmail.com');
        $user->setPlainPassword(base_convert(mt_rand(0x1D39D3E06400000, 0x41C21CB8E0FFFFFF), 10, 36));
        $user->setEnabled(true);
        $user->addRole(User::ROLE_SUPERADMIN);
        $this->userManager->updateUser($user);

        $user = $this->userManager->createUser();
        $user->setUsername('Pascal');
        $user->setEmail('pascalDuplessis@aol.com');
        $user->setPlainPassword(base_convert(mt_rand(0x1D39D3E06400000, 0x41C21CB8E0FFFFFF), 10, 36));
        $user->setEnabled(true);
        $user->addRole(User::ROLE_ADMIN);
        $this->userManager->updateUser($user);

        $this->flush();
    }
}
