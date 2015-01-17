<?php

namespace AppBundle\Service;

use JDare\ClankBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface as Conn;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChatTopic implements TopicInterface, ContainerAwareInterface
{
    protected $container;

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * This will receive any Subscription requests for this topic.
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param $topic
     * @return void
     */
    public function onSubscribe(Conn $conn, $topic)
    {
        //todo move to connection event
        $userId = $conn->Session->get('userId');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $conn->User = $user;
        //this will broadcast the message to ALL subscribers of this topic.
        //$topic->broadcast($conn->resourceId . " has joined " . $topic->getId());
    }

    /**
     * This will receive any UnSubscription requests for this topic.
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param $topic
     * @return void
     */
    public function onUnSubscribe(Conn $conn, $topic)
    {
        //this will broadcast the message to ALL subscribers of this topic.
        //$topic->broadcast($conn->resourceId . " has left " . $topic->getId());
    }


    /**
     * This will receive any Publish requests for this topic.
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param $topic
     * @param $event
     * @param array $exclude
     * @param array $eligible
     * @return mixed|void
     */
    public function onPublish(Conn $conn, $topic, $event, array $exclude, array $eligible)
    {
        $event['sender'] = $conn->User->getUsername();
        //todo add message saving
        $topic->broadcast(array(
            "sender" => $conn->resourceId,
            "topic" => $topic->getId(),
            "event" => $event
        ));
    }

}