<?php
namespace AppBundle\Service;

use JDare\ClankBundle\Event\ClientEvent;

class WebsocketEventListener extends ContainerAwareService
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
        $em = $this->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:User')->find($userId);

        $conn->User = $user;
    }

}