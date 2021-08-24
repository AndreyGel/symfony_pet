<?php

namespace App\Entity;

use App\Repository\StudentSkillRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=StudentSkillRepository::class)
 * @ORM\Table(
 *     name="student_skill",
 *     indexes={
 *         @ORM\Index(name="student_skill__skill_id__ind", columns={"skill_id"}),
 *         @ORM\Index(name="student_skill__student_id__ind", columns={"student_id"})
 *     }
 * )
 */
class StudentSkill
{
    use TimestampableEntity;

    /**
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Skill")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     * })
     */
    private Skill $skill;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", onDelete="CASCADE")
     * })
     */
    private Student $student;

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

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;

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
