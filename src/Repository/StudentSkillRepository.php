<?php

namespace App\Repository;

use App\Entity\StudentSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentSkill[]    findAll()
 * @method StudentSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentSkill::class);
    }

     /**
      * @return StudentSkill[]
      */
    public function findAllByPointWithPagination(int $point, string $operator = '=', int $offset = 0, int $limit = 10): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere("s.point {$operator} :point")
            ->setParameter('point', $point)
            ->orderBy('s.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
