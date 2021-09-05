<?php

namespace App\Controller\Api\Skill\FindOne\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\SkillManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractRestController
{
    private SkillManager $skillManager;

    public function __construct(SkillManager $skillManager)
    {
        $this->skillManager = $skillManager;
    }

    /**
     * @Rest\Get("/api/v1/skill/{skillId}")
     */
    public function __invoke(int $skillId): JsonResponse
    {
        $skill = $this->skillManager->getOneById($skillId);

        if ($skill === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($skill->toArray());
    }
}
