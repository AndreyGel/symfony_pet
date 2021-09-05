<?php

namespace App\Controller\Api\Skill\Update\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\SkillManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractRestController
{
    private SkillManager $skillManager;

    public function __construct(SkillManager $skillManager)
    {
        $this->skillManager = $skillManager;
    }

    /**
     * @Rest\Patch ("/api/v1/skill/{skillId}")
     */
    public function __invoke(Request $request, int $skillId): JsonResponse
    {
        $data = $request->request->all();

        $skill = $this->skillManager->update($skillId, $data);

        if ($skill === null) {
            return new JsonResponse(['success' => false],  Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($skill->toArray());
    }
}
