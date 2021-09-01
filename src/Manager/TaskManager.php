<?php

namespace App\Manager;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager
{
    private EntityManagerInterface $entityManager;

    private TaskRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        /** @var TaskRepository $repository */
        $repository = $entityManager->getRepository(Task::class);
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function getOneById(int $id): ?Task
    {
        return $this->repository->find($id);
    }

    public function create(string $name): int
    {
        $task = (new Task())->setName($name);
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task->getId();
    }

    public function update(int $taskId, array $data): ?Task
    {
        $task = $this->repository->find($taskId);

        if ($task === null) {
            return null;
        }

        if (!empty($data['name'])) {
            $task->setName($data['name']);
        }

        $this->entityManager->flush();

        return $task;
    }

    public function delete(int $taskId): bool
    {
        $task = $this->repository->find($taskId);

        if ($task === null) {
            return false;
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return true;
    }

    public function getTasks(int $offset = 0, int $limit = 10): array
    {
        $tasks = $this->repository->findAllWithPagination($offset, $limit);
        $count = $this->repository->count([]);

        return [
            'items' => $tasks,
            'count' => $count
        ];
    }
}