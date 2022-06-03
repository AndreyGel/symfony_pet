<?php

namespace App\Manager;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\DTO\CreateStudentDTO;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class StudentManager
{
    private EntityManagerInterface $entityManager;
    private StudentRepository $repository;
    private FormFactoryInterface $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        /** @var StudentRepository $repository */
        $repository = $entityManager->getRepository(Student::class);
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
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

    public function getSaveForm(): FormInterface
    {
        return $this->formFactory->createBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
    }

    public function saveStudentFromDTO(Student $student, CreateStudentDTO $studentDTO): ?int
    {
        $student->setName($studentDTO->name);
        $student->setEmail($studentDTO->email);
        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $student->getId();
    }

    public function getUpdateForm(int $studentId): ?FormInterface
    {
        $student = $this->repository->find($studentId);
        if ($student === null) {
            return null;
        }

        return $this->formFactory->createBuilder(FormType::class, CreateStudentDTO::fromEntity($student))
            ->add('login', TextType::class)
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->setMethod('PATCH')
            ->getForm();
    }

    public function updateUserFromDTO(int $studentId, CreateStudentDTO $studentDTO): bool
    {
        $student = $this->repository->find($studentId);
        if ($student === null) {
            return false;
        }

        return $this->saveStudentFromDTO($student, $studentDTO);
    }
}
