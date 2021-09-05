<?php

namespace App\Controller\Api\Skill\Delete\v1;

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
     * @Rest\Delete ("/api/v1/skill/{skillId}")
     */
    public function __invoke(int $skillId): JsonResponse
    {
        $result = $this->skillManager->delete($skillId);

        if ($result === false) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true]);
    }
}
