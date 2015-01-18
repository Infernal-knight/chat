<?php

namespace AppBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\UserBundle\Model\UserInterface;


class UserLoginBlock extends ContainerAwareBlock
{


    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $isLoggedIn = $user instanceof UserInterface;

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->renderResponse('AppBundle:Default\\Block:user_login.html.twig', array(
            'block'     => $blockContext->getBlock(),
            //'error'         => '',
            'csrf_token' => $csrfToken,
            'isLoggedIn' => $isLoggedIn,
        ), $response);

    }
}