<?php

namespace App\Entity;

use App\Repository\CompletedTaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=CompletedTaskRepository::class)
 * @ORM\Table(
 *     name="completed_task",
 *     indexes={
 *         @ORM\Index(name="completed_task__student_id__ind", columns={"student_id"}),
 *         @ORM\Index(name="completed_task__task_id__ind", columns={"task_id"})
 *     }
 * )
 */
class CompletedTask
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", onDelete="CASCADE")
     * })
     */
    private Student $student;

    /**
     * @ORM\ManyToOne(targetEntity="Task")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="task_id", onDelete="CASCADE")
     * })
     */
    private Task $task;

    /**
     * @ORM\Column(type="integer")
     */
    private int $score;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'skill' => $this->student->toArray(),
            'task' => $this->task->toArray(),
            'score' => $this->score,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
