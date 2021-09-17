<?php

namespace App\Controller\Api\Student\GetWithPagination\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\StudentManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractRestController
{
    private StudentManager $studentManager;

    public function __construct(StudentManager $studentManager)
    {
        $this->studentManager = $studentManager;
    }

    /**
     * @Rest\Post("/api/v1/student/paginate")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $pagination = $request->request->get('pagination');

        $limit = $pagination['limit'] ?? 10;
        $offset = $pagination['offset'] ?? 0;

        $students = $this->studentManager->getStudents($offset, $limit);

        return $this->itemsWithPaginationResponse($students, $limit, $offset);
    }
}
