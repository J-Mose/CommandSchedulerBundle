<?php

namespace JMose\CommandSchedulerBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use JMose\CommandSchedulerBundle\Entity\UserHost;

/**
 * UserHostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserHostRepository extends EntityRepository
{
    /**
     * find all existing user/host requirements to be used in select
     *
     * @return array
     */
    public function findAllSelect()
    {
        $result = array();

        $data = $this->findBy(
            array(),
            array('id' => 'ASC')
        );

        /** @var UserHost $right */
        foreach ($data as $right) {
            $user = (($user = $right->getUser()) ? $user : '*');
            $host = (($host = $right->getHost()) ? $host : '*');
            $val = sprintf("%s (%s@%s)",
                $right->getTitle(),
                $user,
                $host
            );
            $result[$right->getId()] = $right;
        }

        return $data;
    }
}
