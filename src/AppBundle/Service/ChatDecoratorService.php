<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

class ChatDecoratorService
{
    public function decorateMessage(User $userFrom, $message)
    {
        $username = $this->getUsername($userFrom);
        return '<i>'.$username.':</i> '.$message.'<br />';
    }

    public function decorateUser(User $user)
    {
        $username = $this->getUsername($user);
        return '<span id="uid'.$user->getId().'">'.$username.'</span> ';
    }

    protected function getUsername(User $user)
    {
        return $user->getFullname()!=' '?$user->getFullname():$user->getUsername();
    }
}