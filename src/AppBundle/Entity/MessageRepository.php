<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends EntityRepository
{
    public function getMessagesFrom($date)
    {
        $query = $this->createQueryBuilder('m')
            ->where('m.created >= :date')
            ->setParameter('date', $date)
            ->orderBy('m.created', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}
