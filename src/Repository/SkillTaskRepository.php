<?php

namespace App\Repository;

use App\Entity\SkillTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillTask[]    findAll()
 * @method SkillTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillTask::class);
    }
}
