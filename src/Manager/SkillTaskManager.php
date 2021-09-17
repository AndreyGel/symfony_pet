<?php

namespace App\Manager;

use App\Entity\Skill;
use App\Entity\SkillTask;
use App\Entity\Task;
use App\Repository\SkillTaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class SkillTaskManager
{
    private EntityManagerInterface $entityManager;

    private SkillTaskRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SkillTaskRepository    $repository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function addSkillTaskPoint(Skill $skill, Task $task, int $point): void
    {
        $skillTasks = $this->repository->findBy(['task' => $task, 'skill' => $skill]);

        if (empty($skillTasks)) {
            $skillTask = (new SkillTask())
                ->setSkill($skill)
                ->setTask($task)
                ->setPoint($point);

            $this->entityManager->persist($skillTask);
            $this->entityManager->flush();
        }
    }
}