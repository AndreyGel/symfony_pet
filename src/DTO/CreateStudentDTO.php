<?php

namespace App\DTO;

use App\Entity\Student;
use Symfony\Component\Validator\Constraints as Assert;

class CreateStudentDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=2)
     */
    public string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=2)
     * @Assert\Email()
     */
    public string $email;


    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
    }

    public static function fromEntity(Student $student): self
    {
        return new self([
            'name' => $student->getName(),
            'email' => $student->getEmail(),
        ]);
    }
}