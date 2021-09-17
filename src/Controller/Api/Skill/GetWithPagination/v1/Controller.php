<?php

namespace App\Controller\Api\Skill\GetWithPagination\v1;

use App\Controller\Api\AbstractRestController;
use App\Manager\SkillManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractRestController
{
    private SkillManager $skillManager;

    public function __construct(SkillManager $skillManager)
    {
        $this->skillManager = $skillManager;
    }

    /**
     * @Rest\Post("/api/v1/skill/paginate")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $pagination = $request->request->get('pagination');

        $limit = $pagination['limit'] ?? 10;
        $offset = $pagination['offset'] ?? 0;

        $skills = $this->skillManager->getSkills($offset, $limit);

        return $this->itemsWithPaginationResponse($skills, $limit, $offset);
    }
}
