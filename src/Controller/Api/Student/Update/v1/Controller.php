<?php

namespace App\Controller\Api\Student\Update\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\StudentManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractRestController
{
    private StudentManager $studentManager;

    public function __construct(StudentManager $studentManager)
    {
        $this->studentManager = $studentManager;
    }

    /**
     * @Rest\Patch ("/api/v1/student/{studentId}")
     */
    public function __invoke(Request $request, int $studentId): JsonResponse
    {
        $data = $request->request->all();

        $student = $this->studentManager->update($studentId, $data);

        if ($student === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($student->toArray());
    }
}
