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
        $chatDecorator = $this->getContainer()->get('app.decorator.chat');

        $topic->broadcast(array(
            'action' => 'userAdd',
            'params' => array('user' => $chatDecorator->decorateUser($conn->User)),
        ));
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
        $topic->broadcast(array(
            'action' => 'userRemove',
            'params' => array('userId' => $conn->User->getId()),
        ));
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
        $chatDecorator = $this->getContainer()->get('app.decorator.chat');

        switch ($event['action']) {
            case 'messageNew':

                $em = $this->getContainer()->get('doctrine')->getManager();

                $messageProcessor = $this->getContainer()->get('app.message.processor');
                $message = $messageProcessor->process($event['params']['message']);
                $message = $chatDecorator->decorateMessage($conn->User, $message);

                $messageEntity = new Message();
                $messageEntity->setSender($conn->User);
                $messageEntity->setCreated(new \DateTime());
                $messageEntity->setText($message);

                $em->persist($messageEntity);
                $em->flush();

                $topic->broadcast(array(
                    'action' => 'messageNew',
                    'params' => array('message' => $message),
                ));
                break;

            case 'userList':
                $users = '';
                foreach ($topic->getIterator() as $connection) {
                    $users[] .= $chatDecorator->decorateUser($connection->User);
                }

                $conn->event($topic->getId(), array(
                    'action' => 'userList',
                    'params' => array('userList' => $users),
                ));
                break;

            default:
                break;
        }


    }

}