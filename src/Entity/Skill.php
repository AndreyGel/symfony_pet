<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 * @ORM\Table(
 *     name="skill",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="skill__name_uniq", columns={"name"})}
 * )
 */
class Skill
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255,  unique=true)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity="StudentSkill", mappedBy="student")
     */
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => array_map(static fn(Student $student) => $student->toArray(), $this->students->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function addStudent(StudentSkill $student): void
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
