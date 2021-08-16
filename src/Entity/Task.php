<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Entity
 * @ORM\Table(
 *     name="task",
 *     indexes={
 *       @ORM\Index(name="task__module_id__ind", columns={"module_id"})
 *     }
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
    private Module $module;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function addStudent(CompletedTask $student)
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
