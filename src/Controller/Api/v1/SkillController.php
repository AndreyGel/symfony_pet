<?php

namespace App\Controller\Api\v1;

use App\Entity\Skill;
use App\Manager\SkillManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route(path="/api/v1/skill")
 */
class SkillController extends AbstractFOSRestController
{
    private SkillManager $skillManager;

    public function __construct(SkillManager $skillManager)
    {
        $this->skillManager = $skillManager;
    }

    /**
     * @Rest\Get("/{skillId}")
     */
    public function find(int $skillId): JsonResponse
    {
        $skill = $this->skillManager->getOneById($skillId);

        if ($skill === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($skill->toArray());
    }

    /**
     * @Rest\Post("")
     * @Rest\RequestParam(name="name", nullable=false)
     */
    public function create(string $name): JsonResponse
    {
        if (empty($name)) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }

        $skill = $this->skillManager->create($name);

        return new JsonResponse(['success' => true, 'id' => $skill]);
    }

    /**
     * @Rest\Post("/paginate")
     */
    public function getPaginate(Request $request): JsonResponse
    {
        $pagination = $request->request->get('pagination');

        $limit = $pagination['limit'] ?? 10;
        $offset = $pagination['offset'] ?? 0;

        $skills = $this->skillManager->getSkills($offset, $limit);

        return new JsonResponse(
            [
                'items' => array_map(static fn(Skill $skill) => $skill->toArray(), $skills['items']),
                'pagination' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'count' => $skills['count']
                ]
            ]
        );
    }

    /**
     * @Rest\Patch("/{skillId}")
     */
    public function update(Request $request, int $skillId): JsonResponse
    {
        $data = $request->request->all();

        $skill = $this->skillManager->update($skillId, $data);

        if ($skill === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($skill->toArray());
    }

    /**
     * @Rest\Delete("/{skillId}")
     */
    public function delete(int $skillId): JsonResponse
    {
        $result = $this->skillManager->delete($skillId);

        if ($result === false) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}