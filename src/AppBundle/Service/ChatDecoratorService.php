<?php

namespace AppBundle\Service;

class ChatDecoratorService
{
    public function decorateMessage($userFrom, $message)
    {
        return '<i>'.$userFrom->getUsername().':</i> '.$message.'<br />';
    }

    public function decorateUser($user)
    {
        return '<span id="uid'.$user->getId().'">'.$user->getUsername().'</span> ';
    }
}