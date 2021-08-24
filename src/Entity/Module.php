<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(
 *     name="`module`",
 *     indexes={
 *         @ORM\Index(name="module__parent_id__ind", columns={"parent_id"}),
 *         @ORM\Index(name="module__tree_root__ind", columns={"tree_root"})
 *     }
 * )
 */
class Module
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
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private int $left;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private int $right;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", onDelete="CASCADE")
     */
    private Module $parent;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    private Collection $children;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumn(name="tree_root",onDelete="CASCADE")
     */
    private Module $root;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private int $level;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="module")
     */
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function addTask(Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }
    }

    public function addChildren(Module $module)
    {
        if (!$this->children->contains($module)) {
            $this->children->add($module);
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

    public function setParent(Module $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent(): Module
    {
        return $this->parent;
    }

    public function getRoot(): Module
    {
        return $this->root;
    }
}
