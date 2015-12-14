<?php

namespace JMose\CommandSchedulerBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use JMose\CommandSchedulerBundle\Entity\ScheduledCommand;
use JMose\CommandSchedulerBundle\Entity\UserHost;

/**
 * Class ScheduledCommandRepository
 *
 * @author  Julien Guyon <julienguyon@hotmail.com>
 * @package JMose\CommandSchedulerBundle\Entity\Repository
 */
class ScheduledCommandRepository extends EntityRepository
{

    /**
     * Find all enabled command ordered by priority
     *
     * @return ScheduledCommand[]
     */
    public function findEnabledCommand()
    {
        return $this->findBy(array('disabled' => false, 'locked' => false), array('priority' => 'DESC'));
    }

    /**
     * findAll override to implement the default orderBy clause
     *
     * @return ScheduledCommand[]
     */
    public function findAll()
    {
        return $this->findBy(array(), array('priority' => 'DESC'));
    }

    /**
     * find a command by id
     *
     * @return ScheduledCommand
     */
    public function findById($id)
    {
        return $this->findBy(array('id' => $id));
    }

//    public function find($id)
//    {
////        $query = $this->getEntityManager()
////            ->createQuery(
////                "SELECT command, rights FROM ScheduledCommand command
////            JOIN command.rights rights
////            WHERE command.ID_SCHEDULED_COMMAND = :id"
////            )->setParameter('id', $id);
////
////        try {
////            $result = $query->getSingleResult();
////            return $result;
////        } catch (\Doctrine\ORM\NoResultException $e) {
////            return null;
////        }
//        $command = $this->findById($id);
//        /** @var ScheduledCommand $cmd */
//        foreach($command as $cmd) {
//            $rights = $cmd->getRights();
//            $rights->__load();
//        }
//        $command = array_shift($command);
//
//        return $command;
//    }
}
