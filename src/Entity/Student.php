<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 * @ORM\Table(
 *     name="student",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="student__email_uniq", columns={"email"})}
 * )
 */
class Student
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $email;

    /**
     * @ORM\OneToMany(targetEntity="CompletedTask", mappedBy="task")
     */
    private Collection $tasks;

    /**
     * @ORM\OneToMany(targetEntity="StudentSkill", mappedBy="skill")
     */
    private Collection $skills;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'tasks' => array_map(static fn(Task $task) => $task->toArray(), $this->tasks->toArray()),
            'skills' => array_map(static fn(Skill $skill) => $skill->toArray(), $this->skills->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function addTask(CompletedTask $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }
    }

    public function addSkill(StudentSkill $skill): void
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
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

    public function getEmail(): string
    {
        return $this->email;
    }

    function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

}
