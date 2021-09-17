<?php

namespace App\Controller\Api\Student\Create\v1;

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
     * @Rest\Post ("/api/v1/student")
     * @Rest\RequestParam(name="name", nullable=false)
     * @Rest\RequestParam(name="email", nullable=false)
     */
    public function __invoke(string $name, string $email): JsonResponse
    {
        if (empty($name)) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }

        $studentId = $this->studentManager->create($name, $email);

        return new JsonResponse(['success' => true, 'id' => $studentId]);
    }
}
