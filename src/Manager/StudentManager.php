<?php

namespace App\Manager;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;

class StudentManager
{
    private EntityManagerInterface $entityManager;

    private StudentRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        /** @var StudentRepository $repository */
        $repository = $entityManager->getRepository(Student::class);
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function getOneById(int $id): ?Student
    {
        return $this->repository->find($id);
    }

    public function create(string $name, string $email): int
    {
        $student = (new Student())
            ->setName($name)
            ->setEmail($email);
        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $student->getId();
    }

    public function update(int $studentId, array $data): ?Student
    {
        $student = $this->repository->find($studentId);

        if ($student === null) {
            return null;
        }

        if (!empty($data['name'])) {
            $student->setName($data['name']);
        }

        if (!empty($data['email'])) {
            $student->setName($data['email']);
        }

        $this->entityManager->flush();

        return $student;
    }

    public function delete(int $studentId): bool
    {
        $student = $this->repository->find($studentId);

        if ($student === null) {
            return false;
        }

        $this->entityManager->remove($student);
        $this->entityManager->flush();

        return true;
    }

    public function getStudents(int $offset = 0, int $limit = 10): array
    {
        $students = $this->repository->findAllWithPagination($offset, $limit);
        $count = $this->repository->count([]);

        return [
            'items' => $students,
            'pages' => ceil($count/$limit)
        ];
    }
}
