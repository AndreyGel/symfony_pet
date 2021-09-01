<?php

namespace App\Controller\Api\v1;

use App\Entity\Task;
use App\Manager\TaskManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route(path="/api/v1/task")
 */
class TaskController extends AbstractFOSRestController
{
    private TaskManager $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @Rest\Get("/{taskId}")
     */
    public function find(int $taskId): JsonResponse
    {
        $Task = $this->taskManager->getOneById($taskId);

        if ($Task === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($Task->toArray());
    }

    /**
     * @Rest\Post("")
     * @Rest\RequestParam(name="name", nullable=false)
     */
    public function create(string $name): JsonResponse
    {
        if (empty($name)) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }

        $taskId = $this->taskManager->create($name);

        return new JsonResponse(['success' => true, 'id' => $taskId]);
    }

    /**
     * @Rest\Post("/paginate")
     */
    public function getPaginate(Request $request): JsonResponse
    {
        $pagination = $request->request->get('pagination');

        $limit = $pagination['limit'] ?? 10;
        $offset = $pagination['offset'] ?? 0;

        $tasks = $this->taskManager->getTasks($offset, $limit);

        return new JsonResponse(
            [
                'items' => array_map(static fn(Task $Task) => $Task->toArray(), $tasks['items']),
                'pagination' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'count' => $tasks['count']
                ]
            ]
        );
    }

    /**
     * @Rest\Patch("/{taskId}")
     */
    public function update(Request $request, int $taskId): JsonResponse
    {
        $data = $request->request->all();

        $task = $this->taskManager->update($taskId, $data);

        if ($task === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($task->toArray());
    }

    /**
     * @Rest\Delete("/{taskId}")
     */
    public function delete(int $taskId): JsonResponse
    {
        $result = $this->taskManager->delete($taskId);

        if ($result === false) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}