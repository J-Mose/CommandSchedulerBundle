<?php

namespace JMose\CommandSchedulerBundle\Entity\Repository;

use JMose\CommandSchedulerBundle\Entity\Execution;
use \Doctrine\ORM\EntityRepository;

/**
 * ExecutionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExecutionRepository extends EntityRepository
{
    /**
     * find all executions fo a given command
     *
     * @param integer $commandId
     * @param boolean|false $returnAsObject set to true to return entity-objects instead of arrays
     *
     * @return array|object
     */
    public function findCommandExecutions($commandId, $returnAsObject = false)
    {
        $logs = $this->findBy(array('command' => $commandId), array('id' => 'ASC'));
        $result = array();

        // we need objects - no more work to do
        if($returnAsObject) {
            return $logs;
        }

        /** @var Execution $log */
        foreach($logs as $log){
            array_push($result, array(
                'executionDate' => $log->getExecutionDate(),
                'runtime' =>$log->getRuntime(),
                'returnCode' => $log->getReturnCode()
            ));
        }

        return $result;
    }

    /**
     * find all executions for command given by id, keep at most $limit
     *
     * @param int $commandId Command ID
     * @param int $limit number of executions to keep at most
     *
     * @return array
     */
    public function findCommandExecutionsLimitNumber($commandId, $limit) {
        $logs = $this->findBy(
            array('command' => $commandId),
            array('id' => 'ASC')
        );

        $logs = array_slice($logs, $limit);

        return $logs;
    }
}
