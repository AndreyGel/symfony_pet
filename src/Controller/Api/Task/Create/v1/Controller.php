<?php

namespace App\Controller\Api\Task\Create\v1;

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
     * @Rest\Post ("/api/v1/task")
     * @Rest\RequestParam(name="name", nullable=false)
     */
    public function __invoke(string $name): JsonResponse
    {
        if (empty($name)) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }

        $taskId = $this->taskManager->create($name);

        return new JsonResponse(['success' => true, 'id' => $taskId]);
    }
}
