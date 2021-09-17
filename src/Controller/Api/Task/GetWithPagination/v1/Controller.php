<?php

namespace App\Controller\Api\Task\GetWithPagination\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\TaskManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractRestController
{
    private TaskManager $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @Rest\Post("/api/v1/task/paginate")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $pagination = $request->request->get('pagination');

        $limit = $pagination['limit'] ?? 10;
        $offset = $pagination['offset'] ?? 0;

        $tasks = $this->taskManager->getTasks($offset, $limit);

        return $this->itemsWithPaginationResponse($tasks, $limit, $offset);
    }
}
