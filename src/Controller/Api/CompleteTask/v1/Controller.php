<?php

namespace App\Controller\Api\CompleteTask\v1;

use App\Service\CompletedTaskService;
use App\Service\TaskBuilderService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route(path="/api/v1/complete-task")
 */
class Controller extends AbstractFOSRestController
{
    private CompletedTaskService $service;

    public function __construct(CompletedTaskService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Post ("")
     * @Rest\RequestParam(name="studentId", nullable=false, requirements="\d+")
     * @Rest\RequestParam(name="taskId", nullable=false, requirements="\d+")
     * @Rest\RequestParam(name="score", nullable=false, requirements="\d+")
     */
    public function __invoke(int $studentId, int $taskId, int $score): JsonResponse
    {
        $success = $this->service->complete($studentId, $taskId, $score);
        if ($success === false) {
            return new JsonResponse(['success' => false], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}