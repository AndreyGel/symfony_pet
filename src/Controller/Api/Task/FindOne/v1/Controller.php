<?php

namespace App\Controller\Api\Task\FindOne\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\TaskManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractRestController
{
    private TaskManager $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @Rest\Get("/api/v1/task/{taskId}")
     */
    public function __invoke(int $taskId): JsonResponse
    {
        $task = $this->taskManager->getOneById($taskId);

        if ($task === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($task->toArray());
    }
}
