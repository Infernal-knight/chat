<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/chat")
     * @Template("AppBundle:Default:chat.html.twig")
     */
    public function chatAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $isLoggedIn = $user instanceof UserInterface;

        $messages = array();

        $chatDecorator = $this->container->get('app.decorator.chat');

        if ($isLoggedIn) {
            $session = $this->container->get('session');
            $session->set('userId', $user->getId());
            $messageRepository = $this->container->get('doctrine')->getManager()->getRepository('AppBundle:Message');

            foreach ($messageRepository->getMessagesFrom(new \DateTime('-1 day')) as $message) {
                $messages[] = $chatDecorator->decorateMessage($message->getSender(), $message->getText());
            }

        }


        return array(
            'isLoggedIn' => $isLoggedIn,
            'host' => $request->getHost(),
            'messages' => $messages,
        );
    }
}
