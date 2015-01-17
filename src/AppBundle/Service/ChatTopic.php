<?php

namespace AppBundle\Service;

use JDare\ClankBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface as Conn;
use AppBundle\Entity\Message;

class ChatTopic extends ContainerAwareService implements TopicInterface
{
    /**
     * This will receive any Subscription requests for this topic.
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param $topic
     * @return void
     */
    public function onSubscribe(Conn $conn, $topic)
    {
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
        switch ($event['action']) {
            case 'messageNew':

                $em = $this->getContainer()->get('doctrine')->getManager();

                $messageProcessor = $this->getContainer()->get('app.message.processor');
                $message = $messageProcessor->process($event['params']['message'], $conn->User->getUsername());

                $messageEntity = new Message();
                $messageEntity->setSender($conn->User);
                $messageEntity->setCreated(new \DateTime());
                $messageEntity->setText($message);

                $em->persist($messageEntity);
                $em->flush();

                //todo add message saving
                $topic->broadcast(array(
                    "action" => "messageNew",
                    "params" => array('message' => $message),
                ));
                break;

            default:
                break;
        }


    }

}