<?php

namespace App\Controller\Api\Skill\Create\v1;

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
     * @Rest\Post ("/api/v1/skill")
     * @Rest\RequestParam(name="name", nullable=false)
     */
    public function __invoke(string $name): JsonResponse
    {
        if (empty($name)) {
            return new JsonResponse(['success' => false], Response::HTTP_BAD_REQUEST);
        }

        $skillId = $this->skillManager->create($name);

        return new JsonResponse(['success' => true, 'id' => $skillId]);
    }
}
