<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractRestController extends AbstractFOSRestController
{
    protected function itemsWithPaginationResponse(array $result, int $limit, int $offset): JsonResponse
    {
        return new JsonResponse(
            [
                'items' => array_map(static fn($item) => $item->toArray(), $result['items']),
                'pagination' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'pages' => $result['pages']
                ]
            ]
        );
    }

}