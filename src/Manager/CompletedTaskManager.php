<?php

namespace App\Manager;


use App\Entity\CompletedTask;
use App\Entity\Student;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class CompletedTaskManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addCompletedTaskScore(Student $student, Task $task, int $score): void
    {
        $completedTask = (new CompletedTask())
            ->setStudent($student)
            ->setTask($task)
            ->setScore($score);

        $this->entityManager->persist($completedTask);
        $this->entityManager->flush();
    }
}