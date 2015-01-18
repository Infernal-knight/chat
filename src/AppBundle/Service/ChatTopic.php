<?php

namespace AppBundle\Service;

use JDare\ClankBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface as Conn;
use AppBundle\Entity\Message;
use Symfony\Component\DependencyInjection\ContainerAware;

class ChatTopic extends ContainerAware implements TopicInterface
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
        $chatDecorator = $this->container->get('app.decorator.chat');

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
        $chatDecorator = $this->container->get('app.decorator.chat');

        switch ($event['action']) {
            case 'messageNew':

                $em = $this->container->get('doctrine')->getManager();

                $messageProcessor = $this->container->get('app.message.processor');
                $message = $messageProcessor->process($event['params']['message']);

                $messageEntity = new Message();
                $messageEntity->setSender($conn->User);
                $messageEntity->setCreated(new \DateTime());
                $messageEntity->setText($message);

                $em->persist($messageEntity);
                $em->flush();

                $message = $chatDecorator->decorateMessage($conn->User, $message);

                $topic->broadcast(array(
                    'action' => 'messageNew',
                    'params' => array('message' => $message),
                ));
                break;

            case 'messagePrivate':

                $em = $this->container->get('doctrine')->getManager();

                $receiverConnection = null;
                foreach ($topic->getIterator() as $connection) {
                    if ($connection->User->getId() == $event['params']['receiver']) {
                        $receiverConnection = $connection;
                        break;
                    }
                }

                if (!$receiverConnection) {
                    echo 'Tried to send private message to an unexisting user...'.PHP_EOL;
                    break;
                }

                $messageProcessor = $this->container->get('app.message.processor');
                $message = $messageProcessor->process($event['params']['message']);

                $messageEntity = new Message();
                $messageEntity->setSender($conn->User);
                $messageEntity->setReceiver($receiverConnection->User);
                $messageEntity->setCreated(new \DateTime());
                $messageEntity->setText($message);

                $em->persist($messageEntity);
                $em->flush();

                $message = $chatDecorator->decorateMessagePrivate($conn->User, $receiverConnection->User, $message);

                $receiverConnection->event($topic->getId(), array(
                    'action' => 'messagePrivate',
                    'params' => array('message' => $message),
                ));

                if ($conn->User->getId() != $receiverConnection->User->getId()) {
                    $conn->event($topic->getId(), array(
                        'action' => 'messagePrivate',
                        'params' => array('message' => $message),
                    ));
                }

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