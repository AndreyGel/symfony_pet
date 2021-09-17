<?php

namespace App\Controller\Api\Task\Delete\v1;

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
     * @Rest\Delete ("/api/v1/task/{taskId}")
     */
    public function __invoke(int $taskId): JsonResponse
    {
        $result = $this->taskManager->delete($taskId);

        if ($result === false) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}
