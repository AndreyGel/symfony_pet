<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(
 *     name="task",
 *     indexes={
 *       @ORM\Index(name="task__module_id__ind", columns={"module_id"})
 *     },
 *     uniqueConstraints={@ORM\UniqueConstraint(name="task__name_uniq", columns={"name"})}
 * )
 */
class Task
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity="CompletedTask", mappedBy="student")
     */
    private Collection $students;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_id", onDelete="SET NULL")
     * })
     */
    private ?Module $module;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'students' => array_map(
                static fn(Student $student) => $student->toArray(), $this->students->toArray()
            ),
            'module' => $this->module ? $this->module->toArray() : null,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function addStudent(CompletedTask $student): void
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }
    }

    public function setModule(Module $module): self
    {
        $this->module = $module;

        return $this;
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
