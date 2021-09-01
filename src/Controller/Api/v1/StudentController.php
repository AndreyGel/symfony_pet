<?php

namespace App\Controller\Api\v1;

use App\Entity\Student;
use App\Manager\StudentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route(path="/api/v1/student")
 */
class StudentController extends AbstractFOSRestController
{
    private StudentManager $studentManager;

    public function __construct(StudentManager $studentManager)
    {
        $this->studentManager = $studentManager;
    }

    /**
     * @Rest\Get("/{studentId}")
     */
    public function find(int $studentId): JsonResponse
    {
        $student = $this->studentManager->getOneById($studentId);

        if ($student === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($student->toArray());
    }

    /**
     * @Rest\Post("")
     * @Rest\RequestParam(name="name", nullable=false)
     * @Rest\RequestParam(name="email", nullable=false)
     */
    public function create(string $name, string $email): JsonResponse
    {
        if (empty($name) || empty($email)) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }

        $studentId = $this->studentManager->create($name, $email);

        return new JsonResponse(['success' => true, 'id' => $studentId]);
    }

    /**
     * @Rest\Post("/paginate")
     */
    public function getPaginate(Request $request): JsonResponse
    {
        $pagination = $request->request->get('pagination');

        $limit = $pagination['limit'] ?? 10;
        $offset = $pagination['offset'] ?? 0;

        $students = $this->studentManager->getStudents($offset, $limit);

        return new JsonResponse(
            [
                'items' => array_map(static fn(Student $student) => $student->toArray(), $students['items']),
                'pagination' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'count' => $students['count']
                ]
            ]
        );
    }

    /**
     * @Rest\Patch("/{studentId}")
     */
    public function update(Request $request, int $studentId): JsonResponse
    {
        $data = $request->request->all();

        $student = $this->studentManager->update($studentId, $data);

        if ($student === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($student->toArray());
    }

    /**
     * @Rest\Delete("/{studentId}")
     */
    public function delete(int $studentId): JsonResponse
    {
        $result = $this->studentManager->delete($studentId);

        if ($result === false) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }

}