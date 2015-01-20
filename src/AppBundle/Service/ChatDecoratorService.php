<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

class ChatDecoratorService
{
    public function decorateMessage(User $userFrom, $message)
    {
        $username = $this->getUsername($userFrom);
        return '<div class="row message"><div class="col-xs-2"><i>'.$username.'</i></div><div class="col-xs-10">'.$message.'</div></div>';
    }

    public function decorateMessagePrivate(User $userFrom, User $userTo, $message)
    {
        $usernameFrom = $this->getUsername($userFrom);
        $usernameTo = $this->getUsername($userTo);
        return '<div class="row message"><div class="col-xs-2"><i>'.$usernameFrom.'<br /><span class="glyphicon glyphicon-arrow-down"></span><br />'.$usernameTo.'</i></div><div class="col-xs-10"> '.$message.'</div></div>';
    }

    public function decorateUser(User $user)
    {
        $username = $this->getUsername($user);
        return '<li class="uid list-group-item" data-uid="'.$user->getId().'">'.$username.'</li> ';
    }

    protected function getUsername(User $user)
    {
        return $user->getFullname()!=' '?/*$user->getFullname()*/$user->getFirstname():$user->getUsername();
    }
}