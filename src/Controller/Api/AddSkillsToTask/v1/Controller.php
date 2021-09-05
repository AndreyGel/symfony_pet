<?php

namespace App\Controller\Api\AddSkillsToTask\v1;

use App\Controller\Api\AbstractRestController;
use App\Service\TaskBuilderService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractRestController
{
    private TaskBuilderService $service;

    public function __construct(TaskBuilderService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Post ("/api/v1/add-skill-task")
     * @Rest\RequestParam(name="taskId", nullable=false, requirements="\d+")
     * @Rest\RequestParam(name="skillIds", nullable=false)
     */
    public function __invoke(int $taskId, array $skillIds): JsonResponse
    {
        $success = $this->service->addSkillsToTask($taskId, $skillIds);
        if ($success === false) {
            return new JsonResponse(['success' => false], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}
