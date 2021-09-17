<?php

namespace App\Controller\Api\Student\Delete\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\StudentManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractRestController
{
    private StudentManager $studentManager;

    public function __construct(StudentManager $studentManager)
    {
        $this->studentManager = $studentManager;
    }

    /**
     * @Rest\Delete ("/api/v1/student/{studentId}")
     */
    public function __invoke(int $studentId): JsonResponse
    {
        $result = $this->studentManager->delete($studentId);

        if ($result === false) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}
