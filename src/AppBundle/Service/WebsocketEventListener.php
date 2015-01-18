<?php
namespace AppBundle\Service;

use JDare\ClankBundle\Event\ClientEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class WebsocketEventListener extends ContainerAware
{
    /**
     * Called whenever a client connects
     *
     * @param ClientEvent $event
     */
    public function onClientConnect(ClientEvent $event)
    {
        $conn = $event->getConnection();

        $userId = $conn->Session->get('userId');
        $em = $this->container->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:User')->find($userId);

        $conn->User = $user;
    }
}