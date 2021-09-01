<?php

namespace App\Manager;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;

class SkillManager
{
    private EntityManagerInterface $entityManager;

    private SkillRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        /** @var SkillRepository $repository */
        $repository = $entityManager->getRepository(Skill::class);
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function getOneById(int $id): ?Skill
    {
        return $this->repository->find($id);
    }

    /** @return Skill[] */
    public function getByIds(array $ids): array
    {
        return $this->repository->findBy(['id' => $ids]);
    }

    public function create(string $name): int
    {
        $skill = (new Skill())->setName($name);
        $this->entityManager->persist($skill);
        $this->entityManager->flush();

        return $skill->getId();
    }

    public function update(int $skillId, array $data): ?Skill
    {
        $skill = $this->repository->find($skillId);

        if ($skill === null) {
            return null;
        }

        if (!empty($data['name'])) {
            $skill->setName($data['name']);
        }

        $this->entityManager->flush();

        return $skill;
    }

    public function delete(int $skillId): bool
    {
        $skill = $this->repository->find($skillId);

        if ($skill === null) {
            return false;
        }

        $this->entityManager->remove($skill);
        $this->entityManager->flush();

        return true;
    }

    public function getSkills(int $offset = 0, int $limit = 10): array
    {
        $skills = $this->repository->findAllWithPagination($offset, $limit);
        $count = $this->repository->count([]);

        return [
            'items' => $skills,
            'count' => $count
        ];
    }
}