<?php

namespace App\Controller\Api\Student\FindOne\v1;

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
     * @Rest\Get("/api/v1/student/{studentId}")
     */
    public function __invoke(int $studentId): JsonResponse
    {
        $student = $this->studentManager->getOneById($studentId);

        if ($student === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($student->toArray());
    }
}
