<?php

namespace App\Entity;

use App\Repository\SkillTaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillTaskRepository::class)
 * @ORM\Table(
 *     name="skill_task",
 *     indexes={
 *         @ORM\Index(name="skill_task__skill_id__ind", columns={"skill_id"}),
 *         @ORM\Index(name="skill_task__task_id__ind", columns={"task_id"})
 *     }
 * )
 */
class SkillTask
{
    /**
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Skill")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="skill_id", onDelete="CASCADE")
     * })
     */
    private Skill $skill;

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
    private int $point;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkill(): Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): self
    {
        $this->skill = $skill;

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

    public function getPoint(): int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }
}
